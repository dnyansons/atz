<?php $this->load->view("affiliate/dashboard/header"); ?>
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
                                        <a href="<?php echo base_url(); ?>affiliate/affiliate"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">My Account</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cover-profile">
                                <div class="profile-bg-img">
                                    <img class="profile-bg-img img-fluid" src="<?php echo base_url(); ?>assets/admin/images/user-profile/bg-img1.jpg" alt="bg-img">
                                    <div class="card-block user-info">
                                        <div class="col-md-12">
                                            <?php
                                            $img = $user->profile_photo;
                                            if (!$img) {
                                                $img = base_url() . "assets/admin/user.png";
                                            }
                                            ?>
                                            <div class="media-left">
                                                <a href="#" class="profile-image">
                                                    <img class="user-img img-radius img-100" src="<?php echo $img; ?>" alt="user-img">
                                                </a>
                                            </div>
                                            <div class="media-body row">
                                                <div class="col-lg-12">
                                                    <div class="user-title">
                                                        <h2><?php echo $affiliateFullname; ?></h2>
                                                        <span class="text-white">Affiliate Marketer</span>
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
                            <?php echo $this->session->flashdata("paymentmessage"); ?>
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

<!--                                            <a id="edit-btn" href="<?php echo base_url(); ?>seller/myaccount/edit_profile" class="btn btn-sm btn-primary waves-effect waves-light f-right">
                                                <span style="color:#fff !important;">Edit Member Profile</span>
                                            </a> -->

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
                                                                                    <td><?php echo $user->fullname; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Company Name</th>
                                                                                    <td><?php echo $user->companyname; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Mobile No</th>
                                                                                    <td><?php echo $user->mobileno; ?></td>
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
                                                                                    <td><a href="#!"><?php echo $user->username; ?></a></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Site Name</th>
                                                                                    <td><a href="#!"><?php echo $user->sitename; ?></a></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Site Url</th>
                                                                                    <td>
                                                                                        <?php echo $user->url; ?>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Registered Date</th>
                                                                                    <td>
                                                                                        <?php echo date("d M Y", strtotime($user->approved_date)); ?>
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
                                            <h5 class="card-header-text">Payment Details</h5>
                                            <a id="edit-btn" href="<?php echo base_url(); ?>affiliate/affiliate/editPaymentDetails/<?php echo $user->id; ?>" class="btn btn-sm btn-primary waves-effect waves-light f-right">
                                                <span style="color:#fff !important;">Edit</span>
                                            </a>
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
                                                                                    <th scope="row">Benificiary Name</th>
                                                                                    <td><?php echo $user->beneficiaryname; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Account Number</th>
                                                                                    <td><?php echo $user->accno; ?></td>
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
                                                                                    <th scope="row">Bank Name</th>
                                                                                    <td><?php echo $user->bankname; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">IFSC Number</th>
                                                                                    <td><?php echo $user->ifscno; ?></td>
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
                                            <h5 class="card-header-text">Sales Rate</h5>
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
                                                                                    <th scope="row">Rate</th>
                                                                                    <td><?php echo $user->rate; ?></td>
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
                                                                                    <th scope="row">Per Order Click</th>
                                                                                    <td><?php echo $user->perclick; ?></td>
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
                                            <h5 class="card-header-text">Affiliate Program Url</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="view-info">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="general-info">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="table-responsive">
                                                                        <table class="table m-0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th  scope="row">Affiliate Url</th>
                                                                                    <td style="width:500px"><b><?php echo $user->refurl; ?></b></td>
                                                                                    <td class="text-left"><a href="" data-toggle="modal" data-target="#myModal" class="text-left text-info"> Know more...</a></td>
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

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>	

<!-- Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" style="font-size:16px">The guidelines are as below:</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <p>If you want to do the marketing of the product link of</p>
                <p><a href="<?php echo base_url(); ?>product-catalog/men_leather_jacket/87"><?php echo base_url(); ?>product-catalog/men_leather_jacket/87</a></p>
                <p>You need to embed the below link in your website.</p>
                <p><?php echo base_url(); ?>ref?id={<strong>Your Affiliate id </strong>}&amp;url={<strong>Your Product URL </strong>}</p>
                <p>Your product URL will contain the product URL from our site which you want to promote on your site.</p>
                <p>example:<strong><?php echo base_url(); ?>ref?id=<?php echo $user->id; ?>&amp;url=product-catalog/men_leather_jacket/87</strong></p>
                <p>Your Affiliate code is <strong><span style="background: yellow;"><?php echo $user->id; ?></span>.</strong></p>
                <p>So your Affiliate link will be as below</p>
                <p><a href="<?php echo base_url(); ?>ref?id=<?php echo $user->id; ?>&amp;url=product-catalog/men_leather_jacket/87"><?php echo base_url(); ?>ref?id=<span style="background: yellow;"><?php echo $user->id; ?></span>&amp;url=product-catalog/men_leather_jacket/87</a></p>
                <p><span style="font-size: 11.0pt; font-family: 'Calibri','sans-serif';">For any assistance or queries you can call on our helpline&nbsp;number&nbsp;<strong><span style="font-family: 'Calibri','sans-serif';">1800-212-2036</span></strong>&nbsp;or feel free to write us on&nbsp;</span><span style="font-size: 11.0pt; font-family: 'Calibri','sans-serif';"><a href="mailto:helpdesk@atzcart.com">helpdesk@atzcart.com</a></span><span style="font-size: 11.0pt; font-family: 'Calibri','sans-serif';">.</span></p>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<?php $this->load->view("affiliate/dashboard/footer"); ?>