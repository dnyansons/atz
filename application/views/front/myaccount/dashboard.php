<?php $this->load->view("front/common/header"); ?>
<style>
    body
    {
    height:auto;
    }
    section{
    padding:10px 0;
    }
    section .section-title{
    text-align:center;
    color:#000;
    margin-bottom:50px;
    text-transform:uppercase;
    }
    #what-we-do{
    }
    #what-we-do .card{
    padding: 1rem!important;
    border: none;
    margin-bottom:1rem;
    -webkit-transition: .5s all ease;
    -moz-transition: .5s all ease;
    transition: .5s all ease;
    border:1px solid #ccc;
    }
    #what-we-do .card:hover{
    -webkit-box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
    -moz-box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
    box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
    }
    #what-we-do .card .card-block{
    padding-left: 50px;
    position: relative;
    }
    #what-we-do .card .card-block a{
    color: #bd081b !important;
    font-weight:700;
    text-decoration:none;
    }
    #what-we-do .card .card-block a i{
    display:none;
    }
    #what-we-do .card:hover .card-block a i{
    display:inline-block;
    font-weight:700;
    }
    #what-we-do .card .card-block:before{
    font-family: FontAwesome;
    position: absolute;
    font-size: 39px;
    color: #bd081b;
    left: 0;
    -webkit-transition: -webkit-transform .2s ease-in-out;
    transition:transform .2s ease-in-out;
    }
    
    #what-we-do .card .block-1:before{
        content: "\f06b";
     }
     #what-we-do .card .block-2:before{
        content: "\f023";
     }
     #what-we-do .card .block-3:before{
        content: "\f01c";
     }
     #what-we-do .card .block-4:before{
        content: "\f041";
     }
     #what-we-do .card .block-5:before{
        content: "\f09d";
     }
     #what-we-do .card .block-6:before{
        content: "\f0d6";
     }
    
    
    #what-we-do .card:hover .card-block:before{
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);	
    -webkit-transition: .5s all ease;
    -moz-transition: .5s all ease;
    transition: .5s all ease;
    }
    h3 {
    font-size:18px;
    margin: 8px 0;}
    p{margin-bottom:5px;}
</style>
<!-- Services section -->
<div class="container">
    <section id="what-we-do">
        <div class="container-fluid">
            <h2 class="section-title mb-1 pl-3 h3 text-left">Your Account</h2>
            <div class="row mt-3">
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                         <a href="<?php echo site_url();?>buyer-orders" >
                        <div class="card-block block-1">
                            <h3 class="card-title">
                                Your Orders
                            </h3>
                            <p class="card-text">Track, return or buy things again.</p>
                        </div>
                              </a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                        <a href="<?php echo base_url(); ?>login-security">
                            <div class="card-block block-2">
                                <h3 class="card-title">Login & Security</h3>
                                <p class="card-text">Edit login & other details.</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                        <a href="<?php echo site_url(); ?>buyer-rfqs">
                            <div class="card-block block-3">

                                <h3 class="card-title">Request For Quotation</h3>
                                <p class="card-text">Track your requests for quotations.</p>

                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                        <a href="<?php echo site_url();?>buyer-addressbook">
                        <div class="card-block block-4">
                            <h3 class="card-title">
                                
                                Your Addresses
                                
                            </h3>
                            <p class="card-text">Create/Edit your shipping addresses.</p>
                        </div>
                            </a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                        <a href="<?php echo base_url(); ?>buyer-payment">
                        <div class="card-block block-5">
                            <h3 class="card-title">Payments</h3>
                            <p class="card-text">Check your payment informations.</p>
                        </div>
                            </a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                         <a href="<?php echo base_url(); ?>buyer-wallet">
                        <div class="card-block block-6">
                            <h3 class="card-title">Your Wallet</h3>
                            <p class="card-text">Check your account balance.</p>
                        </div>
                             </a>
                    </div>
                </div>
            </div>
            <hr style="margin:25px 0">
            <div class="row ">
               
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                         <a href="<?php echo base_url(); ?>buyer-reviews">
                        <div class="card- ">
                            <h3 class="card-title">Reviews</h3>
                            <p class="card-text">My Reviews</p>
                        </div>
                              </a>
                    </div>
                </div>
                   
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                         <a href="<?php echo base_url(); ?>buyer-reviews">
                        <div class="card-">
						<a href="<?php echo site_url();?>buyer-inquiries">
                            <h3 class="card-title">Inquiries</h3>
                            <p class="card-text">My inquiries</p>
						</a>
                        </div>
                          </a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                        <a href="<?php echo base_url(); ?>buyer-coupons">
                        <div class="card-">
                            <h3 class="card-title">Coupons</h3>
                            <p class="card-text">My Coupons</p>
                        </div>
                             </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                          <a href="<?php echo base_url(); ?>favorite">
                        <div class="card- ">
                            <h3 class="card-title">Favorites</h3>
                            <p class="card-text">My Favorite sellers</p>
                            <p class="card-text">My Favorite products</p>
                        </div>
                              </a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                        <a href="<?php echo base_url(); ?>">
                        <div class="card- ">
                            <h3 class="card-title">Recommended</h3>
                            <p class="card-text">Products</p>
                            <p class="card-text">Sellers</p>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                        <a href="<?php echo base_url(); ?>buyer/addbankdetails">
                        <div class="card- ">
                            <h3 class="card-title">Bank Details</h3>
                            <p class="card-text">Buyer</p>
                            <p class="card-text">Add Details</p>
                        </div>
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
</div>
<hr/>

<?php $this->load->view("front/common/footer"); ?>