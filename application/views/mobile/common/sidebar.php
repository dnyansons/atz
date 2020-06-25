<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info" style=" background: url(<?php echo base_url(); ?>assets/mobile/images/user-img-background.jpg) no-repeat no-repeat;">
            <div class="image">
                <img src="<?php echo base_url(); ?>assets/mobile/images/user.png" width="48" height="48" alt="User" />
            </div>
            <?php if (!$this->session->userdata("user_logged_in")) { ?>
                <div class="info-container">
                    <div class="name">  <a href="<?php echo base_url(); ?>signin"> Sign In </a> |  <a href="<?php echo base_url() ?>register"> Register </a>  </div>
                </div>
            <?php } else { ?>
                <div class="info-container">
                    <div class="name"> <?php echo $this->session->userdata("user_name"); ?></div>
                </div>
            <?php } ?>
        </div>
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="active">
                    <a href="<?php echo base_url(); ?>">
                        <span> <i class="icon ion-ios-home"></i> Home</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>home/send_enquiry">
                        <span><i class="icon ion-email"></i> Inquiries</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>home/rfq" class="menu-toggle">
                        <span> <i class="icon ion-chatbox-working"></i> RFQ</span>
                    </a>

                </li>
                <?php if ($this->session->userdata("user_logged_in")) { ?>
                <li>
                    <a href="<?php echo base_url(); ?>home/myorders" class="menu-toggle">
                        <span><i class="icon ion-bag"></i> My Orders
                        </span>
                        <span class="badge badge-pill badge-danger pull-rights text-white"><?php //echo $orders_count; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>home/mycart" class="menu-toggle">
                        <span><i class="icon ion-android-cart"></i> My Cart
                        </span>

                        <span class="badge badge-pill badge-danger pull-rights text-white"><?php //echo $cart_count; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>home/favourite" class="menu-toggle">
                        <span> <i class="icon ion-ios-star"></i>  My Favorites
                        </span>
                        <span class="badge badge-pill badge-danger pull-rights text-white"><?php //echo $fav_count; ?></span>
                    </a>

                </li>
<!--                <li>
                    <a href="<?php //echo base_url(); ?>home/coupons" class="menu-toggle">
                        <span><i class="icon ion-ios-bookmarks"></i> My Coupons</span>
                    </a>
</li>-->
                <li>
                    <a href="<?php echo base_url(); ?>m/mywallet" >
                        <span><i class="icon ion-ios-bookmarks"></i> My Wallet</span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo base_url(); ?>m/bank" >
                        <span><i class="icon ion-ios-home-outline"></i> Bank Details</span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo base_url(); ?>signin/change_password" class="menu-toggle">
                        <span><i class="icon ion-ios-locked"></i> Change Password </span>
                    </a>
                </li>

                <?php } ?>
                <li>
                    <a href="<?php echo base_url(); ?>policy" rel="nofollow"><span><i class="icon ion-android-map"></i> Privacy Policy</span></a>
                </li>

                <li>
                    <a href="<?php echo base_url(); ?>policy/cookie" rel="nofollow">
                        <span><i class="icon ion-clipboard"></i> Cookie policy</span></a>
                </li>
                
                <li>
                    <a href="<?php echo base_url(); ?>help" rel="nofollow">
                        <span><i class="icon ion-headphone"></i> Help Center</span></a>
                </li>

                <li>
                    <a href="<?php echo base_url(); ?>policy/term"  rel="nofollow"><span><i class="icon ion-help-circled"></i> Terms of Use</span></a>
                </li>

                <li>
                    <?php if ($this->session->userdata("user_logged_in")) { ?>
                        <a href="<?php echo base_url(); ?>signout"  class="menu-toggle">
                            <span> <i class="icon ion-power"></i> Sign out</span>
                        </a>
                    <?php } ?>
                </li>

                <li>
                    <div class="">
                        <a class="item flex download-app line-top" href="https://play.google.com/store/apps/details?id=com.atzcart.in&hl=en">
                            <i class="icon ion-android-download text-black" style="font-size:22px;color:#666666"></i>
                            <div class="action flex-1">
                                <div class="flex">
                                    <h3 class="flex-1">ATZCart.com</h3>
                                    <p class="get-app flex-1">GET APP</p>
                                </div>
                                <p class="description">Greater stability and upgraded communication tools</p>
                            </div>
                        </a>
                    </div>
                </li>
                <div class="company-info" style="padding:15px;">
                    <p><small>@2019 ATZCart.com. All rights reserved.</small></p>
                </div>
            </ul>
        </div>
     </aside>
</div>