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
    color: #007b5e !important;
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
    color: #007b5e;
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
                        <div class="card-block block-1">
                            <h3 class="card-title">
                                <a href="#" >
                                    Your Orders
                                </a>
                            </h3>
                            <p class="card-text">Track, return or buy things again.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                        <div class="card-block block-2">
                            <h3 class="card-title">Login & Security</h3>
                            <p class="card-text">Edit login & other details.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                        <div class="card-block block-3">
                            <h3 class="card-title">Rfqs</h3>
                            <p class="card-text">Track your requests for quotations.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                        <div class="card-block block-4">
                            <h3 class="card-title">
                                <a href="<?php echo site_url();?>buyer/addressbook/<?php echo $this->session->userdata('userid');?>">
                                Your addresses
                                </a>
                            </h3>
                            <p class="card-text">Create/Edit your shipping addresses.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                        <div class="card-block block-5">
                            <h3 class="card-title">Payments</h3>
                            <p class="card-text">Check your payment informations.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                        <div class="card-block block-6">
                            <h3 class="card-title">Your wallet</h3>
                            <p class="card-text">check your account balance.</p>
                        </div>
                    </div>
                </div>
            </div>
            <hr style="margin:25px 0">
            <div class="row ">
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                        <div class="card- ">
                            <h3 class="card-title">Reviews</h3>
                            <p class="card-text">My reviews</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                        <div class="card-">
                            <h3 class="card-title">Inquiries</h3>
                            <p class="card-text">My inquiries</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                        <div class="card- ">
                            <h3 class="card-title">Coupons</h3>
                            <p class="card-text">My coupons</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                        <div class="card- ">
                            <h3 class="card-title">Favorites</h3>
                            <p class="card-text">My Favorite sellers</p>
                            <p class="card-text">My Favorite products</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <div class="card">
                        <div class="card- ">
                            <h3 class="card-title">Recommended</h3>
                            <p class="card-text">Products</p>
                            <p class="card-text">Sellers</p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
</div>
<hr />
    <div class="container">
        <h4 class="">
            <a href="#">Your recently viewed items and featured recommendations</a>
        </h4>
        <p>
            After viewing product detail pages, look here to find an easy way to navigate back to pages you are interested in
        </p>
    </div>
<hr />
<?php $this->load->view("front/common/footer"); ?>