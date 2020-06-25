<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/ionicons.min.css">
        <title><?php echo $company->company_name; ?></title>
        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url(); ?>assets/front/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <style>
            body {
                padding-top: 56px;
            }
        </style>
    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#"><?php echo $company->company_name; ?></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <!-- <li class="nav-item active">
                           <a class="nav-link" href="#">Home
                               <span class="sr-only">(current)</span>
                           </a>
                       </li>
                     <li class="nav-item">
                           <a class="nav-link" href="#">About</a>
                       </li>
                       <li class="nav-item">
                           <a class="nav-link" href="#">Products</a>
                       </li>
                       <li class="nav-item">
                           <a class="nav-link" href="#">Contact</a>
                       </li>-->
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Jumbotron Header -->
        <header class="jumbotron text-center">
            <h3 class="display-3 ">A Warm Welcome!</h3>
            <p class="lead ">
                <?php echo $company->introduction; ?>
            </p>
        </header>
        <!-- Page Content -->
        <div class="container" style="min-height:450px !important;">

            <!-- Page Features -->
            <div class="col-md-12">
                <h2 class="sub-title label label">
                    Our Products
                </h2>
            </div>
            <div class="row text-center">
                <?php
                $arrayOffers = array();
                foreach ($products as $product):

                    $arrayOffers['offer_status'] = $product['offer_status'];
                    $arrayOffers['offer_start_time'] = $product['offer_start_time'];
                    $arrayOffers['offer_end_time'] = $product['offer_end_time'];
                    $arrayOffers['offer_type'] = $product['offer_type'];
                    $arrayOffers['offerPrice'] = $product['mrp'];
                    $arrayOffers['offer_discount_value'] = $product['offer_discount_value'];
                    $offerDetails = $this->Offer_model->calculateOfferPrice($arrayOffers);
                    if($offerDetails != NULL) {
                        $product['final_price1'] = $offerDetails['offerPrice'];
                        $product['discount'] = $this->Offer_model->offerDiscount($product['offer_type'], $product['offer_discount_value']);
                    } else {
                        if($product['discount'] != 0){
                            $product['discount'] .= ' % ';
                        } else {
                            $product['discount'] = "";
                            $product['mrp'] = "";
                        }
                    }
                    ?>
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-4" style="border:1px solid #e4e4e4;">
                        <div class="card h-100" style="border:0px;">
                            <a style="height:250px; border-bottom:1px solid #ccc; padding:10px;"  href="<?php echo site_url(); ?>product-details/<?php echo $this->Product_model->seoUrl($product['product_name']); ?>/<?php echo $product['product_id']; ?>">
                                <img class="img-thumbnail" style="height:100%;"
                                     src="<?php echo $product['media_url']; ?>"   alt="">

                            </a>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                                <p class="card-text">
                                    <i class="fa fa-inr" aria-hidden="true"></i> <?php echo $product['final_price1']; ?> <br />
                                    <?php if ($product['mrp'] != $product['final_price'] && $product['mrp'] != 0) { ?>
                                        <i class="fa fa-inr" aria-hidden="true"></i> <del><?php echo $product['mrp']; ?> </del>
                                        <span class="text-success"><?php echo $product['discount']; ?></span>
                                    <?php } ?>
                                </p>
                            </div>
                            <div class="">
                                <a href="<?php echo site_url(); ?>product-details/<?php echo humanize($product['product_name']); ?>/<?php echo $product['product_id']; ?>" class="btn btn-default btn-danger mb-4">Click here </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
        <!-- Footer -->
        <footer class="py-5 bg-dark">
            <div class="container">
                <p class="m-0 text-center text-white">Copyright &copy; atzcart 2019</p>
            </div>
            <!-- /.container -->
        </footer>
        <!-- Bootstrap core JavaScript -->
        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/js/bootstrap.min.js"></script>
    </body>
</html>
