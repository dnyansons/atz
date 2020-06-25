<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <title><?php echo $pageTitle; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="icon" href="<?php echo base_url(); ?>assets/admin/images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/icon/feather/css/feather.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/jquery.mCustomScrollbar.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/pages/data-table/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/j-pro-modern.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/icofont.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/js/tageditor/tageditor/css/amsify.suggestags.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/icofont.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/pages/list-scroll/list.css">	
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/bower_components/stroll/css/stroll.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/pages/advance-elements/css/bootstrap-datetimepicker.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap-daterangepicker/css/daterangepicker.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/bower_components/datedropper/css/datedropper.min.css" />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <link rel="manifest" href="<?php echo base_url(); ?>manifest.json">


        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

        <link href="<?php echo base_url(); ?>assets/admin/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/pages/jquery.filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/pages/timeline/style.css">

        <style>
            .notification-drop-menu {
                max-height: 400px;
                overflow:hidden;
                top : 51px !important;
                overflow-y: scroll !important;
            }
        </style>

    </head>
    <body>
        <?php
         $this->db->select("*");
         $this->db->from("buyer_notification");
         $this->db->where("user_id",$affiliateId);
         $this->db->where("type","AffiliatePayment");
         $this->db->where('status','Received');
         $notification_list = $this->db->get()->result();
         $count = count($notification_list);
         
        ?>
        <div class="theme-loader">
            <div class="ball-scale">
                <div class='contain'>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                </div>
            </div>
        </div>

        <div id="pcoded" class="pcoded">
            <div class="pcoded-overlay-box"></div>
            <div class="pcoded-container navbar-wrapper">
                <nav class="navbar header-navbar pcoded-header">
                    <div class="navbar-wrapper">
                        <div class="navbar-logo">
                            <a class="mobile-menu" id="mobile-collapse" href="#!">
                                <i class="feather icon-menu"></i>
                            </a>

                            <img class="img-fluid" src="<?php echo base_url(); ?>assets/admin/images/flogo.png" alt="Theme-Logo" width="150" height="25" />
                            </a>
                            <a class="mobile-options">
                                <i class="feather icon-more-horizontal"></i>
                            </a>
                        </div>
                        <div class="navbar-container container-fluid">
                            <ul class="nav-left">
                                <li class="header-search">

                                </li>
                                <li>
                                    <a href="#!" onclick="javascript:toggleFullScreen()">
                                        <i class="feather icon-maximize full-screen"></i>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav-right">
                                <li class="header-notification">
                                    <div class="dropdown-primary dropdown">
                                        <div class="dropdown-toggle" data-toggle="dropdown">
                                            <i class="feather icon-bell"></i>
                                            <span class="badge bg-c-pink"><?php echo $count; ?></span>
                                        </div>
                                        <ul class="show-notification notification-view dropdown-menu notification-drop-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                            <li>
                                                <h6>Notifications</h6>
                                                <label class="label label-danger">New</label>
                                            </li>
                                            <?php
                                            if (!empty($notification_list)) {
                                                foreach ($notification_list as $notification) {
                                                    switch ($notification->type) {
                                                        case "AffiliatePayment":
                                                            $url = site_url() . "affiliate/affiliate/affiliateBillingList";
                                                            $id = $notification->id;
                                                            break;
                                                      
                                                    }
                                                    ?>
                                                    <li class="notification_url"  data-id="<?php echo $notification->id; ?>" data-url="<?php echo $url; ?>">
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <h5 class="notification-user"><?php echo $notification->title; ?></h5>
                                                                <p class="notification-msg"><?php echo $notification->msg; ?></p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php }
                                            } ?>
                                        </ul>
                                    </div>
                                </li>

                                <li class="user-profile header-notification">
                                    <div class="dropdown-primary dropdown">
                                        <div class="dropdown-toggle" data-toggle="dropdown">
                                            <img src="<?php echo base_url(); ?>assets/admin/images/user-profile/user2.jpg" class="img-radius" alt="User-Profile-Image">
                                            <span><?php echo $affiliateFullname; ?></span>
                                            <i class="feather icon-chevron-down"></i>
                                        </div>
                                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                            <li>
                                                <a href="<?php echo base_url(); ?>affiliate/affiliate/affiliateProfile">
                                                    <i class="feather icon-user"></i> My Account
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url(); ?>affiliate/logout">
                                                    <i class="feather icon-log-out"></i> Logout
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
<?php $this->load->view("affiliate/dashboard/sidebar"); ?>
