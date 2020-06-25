<?php
//if ($this->input->ip_address() != "114.143.151.214" && $this->input->ip_address() != "223.229.223.133" ) {
//   redirect(base_url());
//   exit();
//}
?>
<!DOCTYPE html>
<html lang="en">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <head>
        <title><?php if (isset($pageTitle)) {
    echo $pageTitle;
} else {
    echo "Admin";
} ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="icon" href="<?php echo base_url(); ?>assets/admin/images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bower_components/font-awesome/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/icon/feather/css/feather.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bower_components/select2/css/select2.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap-multiselect/css/bootstrap-multiselect.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/bower_components/multiselect/css/multi-select.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap-tagsinput/css/bootstrap-tagsinput.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/jquery.mCustomScrollbar.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/pages/advance-elements/css/bootstrap-datetimepicker.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap-daterangepicker/css/daterangepicker.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/bower_components/datedropper/css/datedropper.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/bower_components/ekko-lightbox/css/ekko-lightbox.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/bower_components/lightbox2/css/lightbox.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/pages/data-table/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/pages/timeline/style.css">


        <script src="<?php echo base_url(); ?>assets/admin/js/ckeditor/ckeditor/ckeditor.js"></script>
        <link rel="manifest" href="<?php echo base_url(); ?>manifest.json">
        <style>
            .demoTrangle ul{
                max-height : 300px;
                overflow-y : scroll !important;
            }
            .demoTrangle ul {
                top:34px !important; 
            }
            .badge{
                cursor:pointer;
            }
        </style>
    </head>
    <body>
        <?php
        $notification_list = $this->Common_model->select('*', 'admin_notification', ['status' => 'Received'], array(1 => array('colname' => 'id', 'type' => 'DESC')), 5);
        $received_count = $this->Common_model->getAll('admin_notification', array('status' => 'Received'))->num_rows();
        $count = $received_count;
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
                            <a href="<?php echo site_url(); ?>admin/dashboard">
                                <img class="img-fluid" src="<?php echo base_url(); ?>assets/admin/images/flogo.png" alt="Theme-Logo" width="150" height="25" />
                            </a>
                            <a class="mobile-options">
                                <i class="feather icon-more-horizontal"></i>
                            </a>
                        </div>
                        <div class="navbar-container container-fluid">
                            <ul class="nav-left">
                                <li class="header-search">
                                    <div class="main-search morphsearch-search">
                                        <div class="input-group">
                                            <span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
                                            <input type="text" class="form-control">
                                            <span class="input-group-addon search-btn"><i class="feather icon-search"></i></span>
                                        </div>
                                    </div>
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
                                        <div class="demoTrangle">
                                            <ul class="show-notification notification-view dropdown-menu " data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                <li>
                                                    <h6>Notifications</h6>
                                                    <label class="label label-danger">New</label>
                                                </li>
                                                <?php if (!empty($notification_list)) {
                                                    foreach ($notification_list as $notification) { ?>
                                                        <?php
                                                        $type = $notification['type'];
                                                        $redirect_url = '';
                                                        switch ($type) {
                                                            case 'order_place':
                                                                $redirect_url = base_url('admin/order/all_orders/' . $notification['reference_id']);
                                                                $id = $notification['id'];
                                                                break;

                                                            case 'order_cancel':
                                                                $redirect_url = base_url('admin/order/all_orders/' . $notification['reference_id']);
                                                                $id = $notification['id'];
                                                                break;

                                                            case 'order_return':
                                                                $redirect_url = base_url('admin/return_orders');
                                                                $id = $notification['id'];
                                                                break;

                                                            case 'order_refund':
                                                                $redirect_url = base_url('admin/refunds');
                                                                $id = $notification['id'];
                                                                break;

                                                            case 'Inquiry':
                                                                $redirect_url = base_url('admin/inquiries/');
                                                                $id = $notification['id'];
                                                                break;

                                                            case 'RFQ':
                                                                $redirect_url = base_url('admin/rfqs/');
                                                                $id = $notification['id'];
                                                                break;

                                                            case 'Buyer_Registration':
                                                                $redirect_url = base_url('admin/users/user_view/' . $notification['reference_id']);
                                                                $id = $notification['id'];
                                                                break;
                                                            case 'Seller_Registration':
                                                                $redirect_url = base_url('admin/seller/profile/' . $notification['reference_id']);
                                                                $id = $notification['id'];
                                                                break;
                                                            case 'Affiliate':
                                                                $redirect_url = base_url('admin/affiliate');
                                                                $id = $notification['id'];
                                                                break;
                                                        }
                                                        ?>
                                                        <li class="notification_url"  data-id = "<?php echo $id; ?>" data-url="<?php echo $redirect_url; ?>">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <h5 class="notification-user"><?php echo $notification['title']; ?></h5>
                                                                    <p class="notification-msg"><?php echo $notification['msg']; ?></p>
                                                                </div>
                                                            </div>
                                                        </li>

    <?php }
} ?>
                                                <li  class="notification_url" data-url="<?php echo base_url(); ?>admin/dashboard/all_admin_notification">
                                                    <div class="media">
                                                        <div class="media-body">
                                                            <hr>
                                                            <h5 class="notification-user" style="text-align:center;">SEE ALL NOTIFICATION</h5>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>

                                <li class="user-profile header-notification">
                                    <div class="dropdown-primary dropdown">
                                        <div class="dropdown-toggle" data-toggle="dropdown">
                                            <img src="<?php echo base_url(); ?>assets/admin/images/user-profile/user2.jpg" class="img-radius" alt="User-Profile-Image">
                                            <span><?php echo $this->session->userdata("admin_email"); ?></span>
                                            <i class="feather icon-chevron-down"></i>
                                        </div>
                                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">

                                            <li>
                                                <a href="<?php echo site_url(); ?>admin/logout">
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
<?php $this->load->view("admin/common/sidebar"); ?>