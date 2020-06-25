<?php $this->load->view('user/common/header'); ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>My Account</h4>
                                    <span>ATZ Cart</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo base_url(); ?>seller/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>seller/myaccount">My Account</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php echo $this->session->flashdata("message");?>
                            <div class="cover-profile">
                                <div class="profile-bg-img">
                                    <img class="profile-bg-img img-fluid" src="<?php echo base_url(); ?>assets/admin/images/user-profile/bg-img1.jpg" alt="bg-img">
                                    <div class="card-block user-info">
                                        <div class="col-md-12">
                                            <?php $img = $user->profile_photo;
                                            if (!$img) {
                                                $img = base_url() . "assets/admin/user.png";
                                            } ?>
                                            <div class="media-left">
                                                <a href="#" class="profile-image">
                                                    <img class="user-img img-radius img-100" src="<?php echo $img; ?>" alt="user-img">
                                                </a>
                                            </div>
                                            <div class="media-body row">
                                                <div class="col-lg-12">
                                                    <div class="user-title">
                                                        <h2><?php echo $this->session->userdata("user_name"); ?></h2>
                                                        <span class="text-white"><?php echo $this->session->userdata("user_role"); ?></span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="pull-right cover-btn">
                                                        <form action="<?php echo site_url();?>seller/myaccount/changepic" method="post" enctype="multipart/form-data">
                                                            <button type="button" class="btn btn-primary m-r-10 m-b-5" id="btnChangePic">Change picture</button>
                                                            <p class="text-success">100*100 - 100 kb</p>
                                                            <input type="file" name="profile_pic" style="display:none;" id="inpChangePic" onchange="this.form.submit()">
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


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tab-header card">
                                <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#personal" role="tab">Personal Info</a>
                                        <div class="slide"></div>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="personal" role="tabpanel">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-header-text">About Me</h5>
											<?php
				if($this->session->userdata('user_role')=='seller')
				{
				?>
                                            <a id="edit-btn" href="<?php echo base_url(); ?>seller/myaccount/edit_profile" class="btn btn-sm btn-primary waves-effect waves-light f-right">
                                                <span style="color:#fff !important;">Edit Member Profile</span>
                                            </a> 
				<?php } else { ?>
				 <a id="edit-btn" href="<?php echo base_url(); ?>buyer/myaccount/edit_profile" class="btn btn-sm btn-primary waves-effect waves-light f-right">
                                                <span style="color:#fff !important;">Edit Member Profile</span>
                                            </a> 
				<?php } ?>
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
                                                                                    <td><a href="#!"><?php echo $user->company_name; ?></a></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Mobile Number</th>
                                                                                    <td>
                                                                                        <?php echo $user->phone; ?>
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
                                            <h5 class="card-header-text">Company Information (Status : <?php echo $user->approved_status; ?>)</h5>
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
                                                                                <tr>
                                                                                    <th scope="row">GST NO</th>
                                                                                    <td><?php echo $user->gst_no; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">PAN NO</th>
                                                                                    <td><?php echo $user->pan_no; ?></td>
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
                                            <h5 class="card-header-text">Account Security</h5>
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
																			<?php
				if($this->session->userdata('user_role')=='seller')
				{
				?>
                                                                                <tr>
                                                                                    <th scope="row"><a href="<?php echo base_url(); ?>seller/myaccount/change_password">Change Password</a></th>
                                                                                    <th scope="row"><a href="<?php echo base_url(); ?>seller/myaccount/set_security_questions">Security Questions</a></th>
                                                                                </tr>
                                                                                <tr>
                                                                               
                                                                                    <th scope="row"><a href="<?php echo base_url(); ?>seller/myaccount/email_preferences">Email Services</a></th>
                                                                                     <th scope="row"></th>
                                                                                </tr>
				<?php }else { ?>
				        <tr>
                                                                                    <th scope="row"><a href="<?php echo base_url(); ?>buyer/myaccount/set_security_questions">Security Questions</a></th>
                                                                                    <th scope="row"><a href="<?php echo base_url(); ?>buyer/myaccount/privacy_setting">Privacy Setting</a></th>
                                                                                </tr>
                                                                               
				<?php } ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-xl-6">
                                                                    <div class="table-responsive">
                                                                        <table class="table m-0">
                                                                            <tbody>
																			<?php
				if($this->session->userdata('user_role')=='seller')
				{
				?>
                                                                                <tr>
                                                                                    <th scope="row"><a href="<?php echo base_url(); ?>seller/myaccount/change_email_address">Change Email Address</a></th>
                                                                                    <th scope="row"><a href="<?php echo base_url(); ?>seller/myaccount/email_preferences">Manage Verification Phones</a></th>
                                                                                </tr>
				<?php } else { ?>
				<tr>
                                                                                    <th scope="row"><a href="<?php echo base_url(); ?>buyer/myaccount/change_email_address">Change Email Address</a></th>
                                                                                    <th scope="row"><a href="<?php echo base_url(); ?>buyer/myaccount/email_preferences">Manage Verification Phones</a></th>
                                                                                </tr>
				<?php } ?>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>	
<script>
    function check_profile()
    {
        var a = $('#myfile').val();
        if (a == '')
        {
            $("#perror").html("<span style='color:red'>Please Select Profile Image to Upload !");
            return false;
        }
    }
    
$(document).ready(function(){
    $("#btnChangePic").click(function(){
        $("#inpChangePic").trigger("click");
    });
})
    
</script>
<?php $this->load->view('user/common/footer'); ?>