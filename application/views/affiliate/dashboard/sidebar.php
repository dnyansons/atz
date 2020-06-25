<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <nav class="pcoded-navbar">
            <div class="pcoded-inner-navbar main-menu">
                <div class="pcoded-navigatio-lavel" >
                    Navigation
                </div>
                <ul class="pcoded-item pcoded-left-item">
                    <li class="">
                        <a href="<?php echo site_url(); ?>affiliate/affiliate">
                            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                            <span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li>
<!--                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="fa fa-building"></i></span>
                            <span class="pcoded-mtext">Transactions</span>
                        </a>
                    </li>-->

                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="fa fa-building"></i></span>
                            <span class="pcoded-mtext">Billings</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class=" ">
                                <a href="<?php echo site_url(); ?>affiliate/affiliate/affiliateBillingList">
                                    <span class="pcoded-mtext">Paid</span>
                                </a>
                            </li>
                            <li class=" ">
                                <a href="<?php echo site_url(); ?>affiliate/affiliate/affiliateBillinghold">
                                    <span class="pcoded-mtext">Hold</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="pcoded-hasmenu">
                       <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="fa fa-cogs"></i></span>
                            <span class="pcoded-mtext">Settings</span>
                        </a>
                        <ul class="pcoded-submenu">

                            <li class=" ">
                                <a href="<?php echo site_url(); ?>affiliate/affiliate/changePassword">
                                    <span class="pcoded-mtext">Change Password</span>
                                </a>
                            </li>
                        </ul>
                       </li>
                    </li>
                    
                </ul>
            </div>
        </nav>

