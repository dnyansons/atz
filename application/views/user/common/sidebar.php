<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <nav class="pcoded-navbar">
            <div class="pcoded-inner-navbar main-menu">
                <div class="pcoded-navigatio-lavel" >
                    Navigation
                </div>
                <ul class="pcoded-item pcoded-left-item">
                    <li class="">
                        <a href="<?php echo site_url(); ?>seller/dashboard">
                            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                            <span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li>
                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="fa fa-building"></i></span>
                            <span class="pcoded-mtext">Company & Site</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class=" ">
                                <a href="<?php echo site_url(); ?>seller/companyprofile">
                                    <span class="pcoded-mtext">Manage Company profile</span>
                                </a>
                            </li>
                            <li class=" ">
                                <a href="<?php echo site_url(); ?>seller/pickupaddress">
                                    <span class="pcoded-mtext">Pick Up Address</span>
                                </a>
                            </li>
                            <li class=" ">
                                <a href="<?php echo site_url(); ?>seller/companyprofile/company_documents/">
                                    <span class="pcoded-mtext">Documents/Certificates</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="<?php echo site_url(); ?>seller/bank">
                                    <span class="pcoded-mtext">Bank details</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="fa fa-shopping-cart"></i></span>
                            <span class="pcoded-mtext">Order Management</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class=" ">
                                <a href="<?php echo site_url(); ?>seller/orders">
                                    <span class="pcoded-mtext">All Orders</span>
                                </a>
                            </li>
                            <li class=" ">
                                <a href="<?php echo site_url(); ?>seller/orders/completed">
                                    <span class="pcoded-mtext">Completed</span>
                                </a>
                            </li>
                            <li class=" ">
                                <a href="<?php echo site_url(); ?>seller/orders/processing">
                                    <span class="pcoded-mtext">Processing</span>
                                </a>
                            </li>
                            <li class=" ">
                                <a href="<?php echo site_url(); ?>seller/orders/rejected">
                                    <span class="pcoded-mtext">Rejected</span>
                                </a>
                            </li>
                            <li class=" ">
                                <a href="<?php echo site_url(); ?>seller/orders/return_order">
                                    <span class="pcoded-mtext">Return</span> 
                                </a>
                            </li>
                            <li class=" ">
                                <a href="<?php echo site_url(); ?>seller/refund/refund_request">
                                    <span class="pcoded-mtext">Refund Request</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="fa fa-gift"></i></span>
                            <span class="pcoded-mtext">Product Management</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class=" ">
                                <a href="<?php echo site_url(); ?>seller/products/create">
                                    <span class="pcoded-mtext">Create a new Product</span>
                                </a>
                            </li>
                            <li class=" ">
                                <a href="<?php echo site_url(); ?>seller/bulkimport">
                                    <span class="pcoded-mtext">Bulk Product Upload</span>
                                </a>
                            </li>
                            <li class=" ">
                                <a href="<?php echo site_url(); ?>seller/products/initiated">
                                    <span class="pcoded-mtext">Initiated</span>
                                </a>
                            </li>
                            <li class=" ">
                                <a href="<?php echo site_url(); ?>seller/products/pending">
                                    <span class="pcoded-mtext">Pending</span>
                                </a>
                            </li>
                            <li class=" ">
                                <a href="<?php echo site_url(); ?>seller/products">
                                    <span class="pcoded-mtext">Approved</span>
                                </a>
                            </li>
                             <li class=" ">
                                <a href="<?php echo site_url(); ?>seller/products/rejectedProducts">
                                    <span class="pcoded-mtext">Rejected</span>
                                </a>
                            </li> 
                        </ul>
                    </li>
<!--                    <li class="">
                        <a href="<?php echo site_url(); ?>seller/inquiries">
                            <span class="pcoded-micon"><i class="feather icon-list"></i></span>
                            <span class="pcoded-mtext">Inquiries</span>
                        </a>
                    </li>-->
                    <li class="">
                        <a href="<?php echo site_url(); ?>seller/rfqs">
                            <span class="pcoded-micon"><i class="fa fa-tasks"></i></span>
                            <span class="pcoded-mtext">Request for quotation</span>
                        </a>
                    </li>
                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="fa fa-cogs"></i></span>
                            <span class="pcoded-mtext">Account & Settings</span>
                        </a>
                        <ul class="pcoded-submenu">
           
							<li class=" ">
                                <a href="<?php echo site_url(); ?>seller/Myaccount/change_password">
                                    <span class="pcoded-mtext">Change Password</span>
                                </a>
                            </li>
							<li class=" ">
                                <a href="<?php echo site_url(); ?>seller/Myaccount/change_email_address">
                                    <span class="pcoded-mtext">Change Email Address</span>
                                </a>
                            </li>
							<li class=" ">
                                <a href="<?php echo site_url(); ?>seller/Myaccount/set_security_questions">
                                    <span class="pcoded-mtext">Set Security Questions</span>
                                </a>
                            </li>
							<li class=" ">
                                <a href="<?php echo site_url(); ?>seller/Myaccount/email_preferences">
                                    <span class="pcoded-mtext">Email Preferences</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="fa fa-list"></i></span>
                            <span class="pcoded-mtext">Reports</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class=" ">
                                <a href="<?php echo site_url(); ?>seller/report/sale_report">
                                    <span class="pcoded-mtext">Sale Report</span>
                                </a>
                            </li>
                            <li class=" ">
                                <a href="<?php echo site_url(); ?>seller/report/settlement_report">
                                    <span class="pcoded-mtext">Settlement</span>
                                </a>
                            </li>
                            <li class=" ">
                                <a href="<?php echo site_url(); ?>seller/report/non_settled_report">
                                    <span class="pcoded-mtext">not Settled</span>
                                </a>
                            </li>
                            <li class=" ">
                                <a href="<?php echo site_url(); ?>seller/report/commission_report">
                                    <span class="pcoded-mtext">Commission report</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

