<?php //echo "<pre>";print_r($allorder); exit;?>
<style>
   body{
   height:auto;
   }
   .card{
   border-radius: 0;
   }
   .card .card-header{
   background-color: #fff;
   font-size: 18px;
   padding: 10px 16px;
   }
   .proviewcard .card-body{
   padding: 0;
   }
   .cardlist{
   border-bottom: 1px solid #f0f0f0;
   }
   .cardlist:last-child{
   border: 0;
   }
   .addcartimg{
   height: 100px;
   }
   .cartproname{
   font-size: 15px;
   color: #212529;
   line-height: 1;
   display: inline;
   }
   .cartproname:hover{
   color: #c16302;
   text-decoration: none;
   }
   .seller{
   font-size: 12px;
   color: #666;
   margin-bottom: 5px;
   line-height: 1;
   }
   .cartviewprice{
   margin-bottom: 8px;
   line-height: 1;
   }
   .cartviewprice span{
   display: inline-block;
   padding-right: 10px;
   margin-bottom: 5px;
   }
   .cartviewprice .amt{
   font-size: 18px;
   font-weight: 600;
   }
   .cartviewprice .oldamt{
   color: #757575;
   font-weight: 600;
   text-decoration: line-through;
   }
   .cartviewprice .disamt{
   font-weight: 600;
   color: #c16302;
   }
   .qty .input-group{
   width: 100%;
   height: 25px;
   }
   .btn-qty{
   height: 25px;
   color: #fff !important;
   background-color: #555 !important; 
   border-color: #555 !important;
   padding: 0px 3px !important;
   }
   .qty input{
   height: 25px;
   }
   .addcardrmv{
   font-size: 14px;
   line-height: 1.8;
   text-transform: uppercase;
   color: #212529;
   }
   .addcardrmv:hover{
   color: #c16302;
   text-decoration: none;
   font-weight: 600;
   }
   .prostatus .del-time {
   font-size: 12px;
   color: #757575;
   margin-right: 10px;
   }
   .prostatus .del-time > span {
   font-weight: 600;
   color: #555;
   }
   .proviewcard .card-footer{
   text-align: center;
   box-shadow: rgba(0, 0, 0, 0.1) 0px -2px 10px 0px;
   padding: 8px 15px;
   }
   .card .card-footer{
   background-color: #fff;
   }
   .btn-cust {
   background-color: #fff;
   color: #212121;
   box-shadow: rgba(0, 0, 0, 0.1) 0px 2px 2px 0px;   
   font-weight: 500;   
   order-radius: 2px;
   border-width: 1px;
   border-style: solid;
   border-color: #E0E0E0;
   border-image: initial;
   font-size: 14px;
   padding: 5px 7px;
   min-width: 130px;
   }
   .btn-cust:hover {
   background-color: #c74b14 !important;
   color: #fff !important;
   }
   .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
   color: #fff;
   background-color: #007bff;
   padding: 10px;
   }
   .nav {
   width: 100%;
   height: 40px !important;
   background-color: #FFF;
   box-shadow: 0 2px 2px rgba(0, 0, 0, .12);
   z-index: 1000;
   }
   .nav-link {
   display: block;
   padding: .7rem 1rem;
   }
   .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
   color: #716666;
   background-color:none !important;
   padding: 10px;
   border-bottom: 2px solid #007bff;
   }
   .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
   background:none !important;
   }
   .nav-pills .nav-link {
   border-radius:0px; 
   }
   a:focus
   {
   outline:none;
   }
   input, textarea, select
   {
   border:1px solid #ccc !important;
   }
   .modal-dialog {
   max-width:500px; 
   margin: 1.75rem auto;
   }
   .active1{
	   
	   background-color: #bd2130;
       border-color: #b21f2d;
   }
   .addbtn li a.btn{
    color: #fff;
    margin-left:0px !important; 
    margin-right:0px !important;;
    border: 0px !important;;
    border-radius: 0px !important;;}
   
</style>
<!-- Services section -->
<div class="container">
   <ol id="breadcrumb_CNEP" class="a-ordered-list a-horizontal breadcrumb mt-20">
      <li class="breadcrumb-item "><span class="a-list-item ">
         <a class="a-link-normal" href="<?php echo base_url(); ?>buyer-dashboard">
         Your Account
         </a>
         </span>
      </li>
      <li class="breadcrumb-item active"><span class="a-list-item a-color-state">
         Your Orders
         </span>
      </li>
   </ol>
   <h2 class="mt-35">Your Orders</h2>
   <h6 style="text-align:center;"><?php echo $this->session->flashdata('message'); ?></h6>
   <div class="btn-group" id="allbtninfo" style="margin-bottom:10px;">
      <ul class="nav addbtn" style="background:none; box-shadow:unset">
		  <li class="active1 btn-info ">
		  <a class="btn " id="one" style="color:#fff;margin-left: 5px;margin-right: 3px;" href="<?php echo base_url(); ?>buyer/myorders?order=today">Today</a></li>
		  <li class="btn-info  ml-2">
		  <a class="btn"  id="two"  style="color:#fff;margin-left: 5px;margin-right: 3px;" href="<?php echo base_url(); ?>buyer/myorders?order=yesterday">Yesterday</a></li>
		  <li class=" btn-info ml-2">
		   <a class="btn"  id="three"  style="color:#fff;margin-left: 5px;margin-right: 3px;" href="<?php echo base_url(); ?>buyer/myorders?order=all">All Orders</a></li>
	   </ul>
   </div>
   <br>
   <!-- Nav pills -->
   <ul class="nav nav-pills" role="tablist">
      <li class="nav-item">
         <a class="nav-link active" data-toggle="pill" href="#home"> All Orders</a>
      </li>
      <li class="nav-item">
         <a class="nav-link" data-toggle="pill" href="#menu1"> Cancelled Orders </a>
      </li>
      <li class="nav-item">
         <a class="nav-link" data-toggle="pill" href="#menu2"> Pending Orders</a>
      </li>
      <li class="nav-item">
         <a class="nav-link" data-toggle="pill" href="#menu3"> Completed Orders</a>
      </li>
   </ul>
   <!-- Tab panes -->
   <div class="tab-content">
      <div id="home" class="tab-pane active">
         <br>
         <div class="row">
            <div class="col-lg-12 px-0 pr-lg-2 mb-2 mb-lg-0">
               <div class="card border-light bg-white card proviewcard shadow-sm">
                  <div class="card-header">All Orders
                  </div>
                  <div class="card-body">
                     <div class="col-lg-12 p-3 cardlist">
                        <div class="col-lg-12">
                           <?php
                              $i = 0;
                              foreach ($allorder as $ord) {
                              
                                  echo'<div class="row mb-4" style="border-bottom:1px solid #ccc;">
                              <div class="col-lg-6">
                              <div class="row">';
                                  $pr_details = $this->Order_model->getOrderDetails($ord->orders_id);
                                  $seller_info = $this->Product_model->getSellerInformation($pr_details[$i]->seller_id);
                                  $details = json_decode($pr_details[0]->product_specifications);

                                  ?>
                           <div class="col-3 col-lg-3 col-xl-3 p-1">
                              <div class="row">
                                 <a href="<?php echo base_url() ?>buyer/myorders/order_view/<?php echo $ord->orders_id; ?>" class="w-100">
                                 <img src="<?php echo $details->product_image; ?>" class="mx-auto d-block mb-1 addcartimg">
                                 </a>
                              </div>
                           </div>
                           <div class="col-9 col-lg-9 col-xl-9">
                              <div class="d-block text-truncate mb-1">
                                 <div class="next-table-cell-wrapper" >
                                    <a href="<?php echo base_url() ?>buyer/myorders/order_view/<?php echo $ord->orders_id; ?>" style="text-decoration:none;" title="<?php echo $details->product_name ?>">
                                    Product : <?php
                                       if(strlen($details->product_name) > 23) {
                                           echo substr($details->product_name, 0, 23).'...';
                                       } else{
                                           echo $details->product_name;
                                        }
                                        //Check if product quantity is still available for pending orders
                                        //so not to change the available quantity to negative stock
                                        //if product is out of stock then do not process pending orders
                                        $total_quantity_shopped = $details->specifications[0]->specifications->total_quantity;
                                        $low_stock = $this->Order_model->checkProductAvailQty($details->product_id, $total_quantity_shopped);
                                       ?></a>
                                 </div>
                                 <a href="<?php echo base_url() ?>buyer/myorders/order_view/<?php echo $ord->orders_id; ?>" class="cartproname">
                                    <div class="next-table-cell-wrapper" >
                                       <span>Order No: </span>
                                       <span> #ORD<?php echo $ord->orders_id; ?></span>
                                    </div>
                                 </a>
                              </div>
                              <div class="seller d-block">
                                 <span>Seller: </span>
                                 <span><?php echo $seller_info['company_name']; ?></span>
                              </div>
                              <div class="cartviewprice d-block">
                                 <span class="amt"><i class="fa fa-inr"></i>.  <?php echo number_format($ord->order_price, 2); ?></span>
                              </div>
                              <div class="d-block">
                                 <span class="amt">Date : <?php echo date('d M Y H:i', strtotime($ord->date_purchased)); ?></span>
                              </div>
                              <br>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-2 ml-lg-auto align-self-start mt-2 mt-lg-0">
                        <div class="row">
                           <div class="prostatus">
                              <h5 class="del-time" style="margin-top:45px;"><b>Status : </b><?php echo $pr_details[0]->orders_status_name . ''; ?> </h5>
                              <?php   //if stock is not available then don't let buyer to make payment
                                  if($low_stock == 0 && strtolower($pr_details[0]->orders_status_name) == 'pending') {
                                      echo "<label style='font-weight:bold;font-size:1em;' class='text-danger text-center'>Out Of Stock</label>";
                                  }
                                  ?>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-2 ml-lg-auto align-self-start mt-2 mt-lg-0">
                        <div class="row">
                           <?php
                              if ($ord->orders_status_id == 4) {
                                  ?>
                           <div class="prostatus">
                              <span class="del-time " >
                              <a href="<?php echo base_url();?>finalOrderInvoice/<?php echo $ord->orders_id; ?>" class="btn btn-cust btn-sm" style="margin-top:36px;" >Invoice</a></span>
                              </span>
                           </div>
                           <?php
                              } else {
                                  ?>
                           <div class="prostatus">
                              <span class="del-time " >
                              <a href="<?php echo base_url(); ?>buyer/myorders/order_view/<?php echo $ord->orders_id; ?>" class="btn btn-cust btn-sm" style="margin-top:36px;">Order Detail</a></span>
                              </span>
                           </div>
                           <?php } ?>
                        </div>
                     </div>
                     <div class="col-lg-2 ml-lg-auto align-self-start mt-2 mt-lg-0">
                        <div class="row">
                           <?php
                              if ($ord->order_tracking_status == 1) {
                                  $style = "margin-top:15px;margin-bottom:15px;";
                              } else {
                                  $style = "margin-top:36px;";
                              }
                              if ($ord->orders_status_id != 8) {
                                  ?>
                           <div class="prostatus">
                              <span class="del-time " >
                              <a href="<?php echo base_url(); ?>buyer/myorders/track_order/<?php echo $ord->orders_id; ?>" class="btn btn-cust btn-sm" style="<?php echo $style; ?>">Track Order</a></span>
                              </span>
                           </div>
                           <?php
                              }
                              if ($ord->orders_status_id == 8) {
                                  ?>
                           <div class="prostatus">
                              <span class="del-time " >
                              <?php //if stock is not available then don't let buyer to make payment
                                  if($low_stock != 0) { ?>
                              <a href="<?php echo base_url(); ?>userorder/ship_order/<?php echo $ord->orders_id; ?>" style="margin-top:15px;" class="btn btn-cust btn-sm">Make Payment</a></span>
                               <?php } else {?>
                                   <button class = 'notify-class btn btn-cust btn-sm placeorder' style="background: #bd081b;color: #FFF;border-color: #bd081b;"
                                           id="notify_buyer" <?php echo $class ?>
                                           data-id="<?php echo $details->product_id; ?>">Notify Me
                                   </button>
                               <?php }?>
                              </span>
                           </div>
                           <div class="prostatus">
                              <span class="del-time " >
                              <a onclick="return confirm('Are You Sure ?');" href="<?php echo base_url(); ?>buyer/myorders/remove_order/<?php echo $ord->orders_id; ?>" class="btn btn-cust btn-sm" style="<?php echo $style; ?>">Remove Order</a></span>
                              </span>
                           </div>
                           <?php
                              }
                              
                              if ($ord->order_tracking_status == 1) {
                                  ?>
                           <?php if ($ord->orders_status_id == 4) { ?> 
                           <a href="<?php echo site_url(); ?>buyer/return_order/index/<?php echo $ord->orders_id; ?>" class="btn btn-cust btn-sm">Help Desk</a> 
                           <?php
                              } else {
                                  $arr = array(9, 10, 16, 18, 19, 22, 26);
                                  if (in_array($ord->orders_status_id, $arr)) {
                                      ?>
                           <button type="button" class="btn btn-cust btn-sm" data-toggle="modal" data-target="#CancelOrder" value="<?php echo $ord->orders_id; ?>"  onclick="cancel_order(this.value);">Cancel Order</button>
                           <?php }
                              ?>
                           <?php } ?>
                           <?php } ?>
                        </div>
                     </div>
                  </div>
                  <?php } ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<div id="menu1" class="tab-pane fade">
   <br>
   <div class="row">
      <div class="col-lg-12 px-0 pr-lg-2 mb-2 mb-lg-0">
         <div class="card border-light bg-white card proviewcard shadow-sm">
            <div class="card-header">Cancelled Order</div>
            <div class="card-body">
               <div class="col-lg-12 p-3 cardlist">
                  <div class="col-lg-12">
                     <?php
                        foreach ($allorder as $ord) {
                            if ($ord->orders_status == 1 || $ord->orders_status == 20 || $ord->orders_status == 25) {
                                echo'<div class="row mb-4" style="border-bottom:1px solid #ccc;">
                        									<div class="col-lg-8">
                        								<div class="row">';
                                $pr_details = $this->Order_model->getOrderDetails($ord->orders_id);
                        
                                $seller_info = $this->Product_model->getSellerInformation($pr_details[$i]->seller_id);
                        
                                $details = json_decode($pr_details[0]->product_specifications);
                                ?>
                     <div class="col-3 col-lg-3 col-xl-3">
                        <div class="row">
                           <a href="<?php echo base_url() ?>buyer/myorders/order_view/<?php echo $ord->orders_id; ?>" class="w-100">
                           <img src="<?php echo $details->product_image; ?>" class="mx-auto d-block mb-1 addcartimg">
                           </a>
                        </div>
                     </div>
                     <div class="col-9 col-lg-9 col-xl-9">
                        <div class="d-block text-truncate mb-1">
                           <div class="next-table-cell-wrapper" >
                              <a href="<?php echo base_url() ?>buyer/myorders/order_view/<?php echo $ord->orders_id; ?>" style="text-decoration:none;" title="<?php echo $details->product_name ?>">
                              Product : <?php 
                                 if(strlen($details->product_name) > 23) { 
                                     echo substr($details->product_name, 0, 23).'...';
                                 } else{
                                     echo $details->product_name;
                                  }
                                 ?></a>
                           </div>
                           <a href="<?php echo base_url() ?>buyer/myorders/order_view/<?php echo $ord->orders_id; ?>" class="cartproname">
                              <div class="next-table-cell-wrapper" >
                                 <span>Order No: </span>
                                 <span> #ORD<?php echo $ord->orders_id; ?></span>
                              </div>
                           </a>
                        </div>
                        <div class="seller d-block">
                           <span>Seller: </span>
                           <span><?php echo $seller_info['company_name']; ?></span>
                        </div>
                        <div class="cartviewprice d-block">
                           <span class="amt"><i class="fa fa-inr"></i>.  <?php echo number_format($ord->order_price, 2); ?></span>
                        </div>
                        <div class="d-block">
                           <span class="amt">Date : <?php echo date('d M Y H:i', strtotime($ord->date_purchased)); ?></span>
                        </div>
                        <br>
                     </div>
                  </div>
               </div>
               <div class="col-lg-2 ml-lg-auto align-self-start mt-2 mt-lg-0">
                  <div class="row">
                     <div class="prostatus">
                        <h5 class="del-time" style="margin-top:45px;"><b>Status : </b><?php echo $pr_details[0]->orders_status_name; ?> </h5>
                     </div>
                  </div>
               </div>
               <div class="col-lg-2 ml-lg-auto align-self-start mt-2 mt-lg-0">
                  <div class="row">
                     <div class="prostatus">
                        <span class="del-time " >
                        </span>
                        </span>
                     </div>
                  </div>
               </div>
            </div>
            <?php
               }
               }
               ?>
         </div>
      </div>
   </div>
</div>
</div>
</div>
</div>
<div id="menu2" class=" tab-pane fade">
   <br>         
   <div class="row">
      <div class="col-lg-12 px-0 pr-lg-2 mb-2 mb-lg-0">
         <div class="card border-light bg-white card proviewcard shadow-sm">
            <div class="card-header">Pending Order</div>
            <div class="card-body">
               <div class="col-lg-12 p-3 cardlist">
                  <div class="col-lg-12">
                     <?php
                        $i = 0;
                        foreach ($allorder as $ord) {
                            if ($ord->orders_status == 8) {
                                echo'<div class="row mb-4" style="border-bottom:1px solid #ccc;">
                        									<div class="col-lg-8">
                        								<div class="row">';
                                $pr_details = $this->Order_model->getOrderDetails($ord->orders_id);
                        
                                $seller_info = $this->Product_model->getSellerInformation($pr_details[$i]->seller_id);

                                $details = json_decode($pr_details[0]->product_specifications);
                                 //Check if product quantity is still available for pending orders
                                 //so not to change the available quantity to negative stock
                                 //if product is out of stock then do not process pending orders
                                 $total_quantity_shopped = $details->specifications[0]->specifications->total_quantity;
                                 $low_stock = $this->Order_model->checkProductAvailQty($details->product_id, $total_quantity_shopped);
                                ?>
                     <div class="col-3 col-lg-3 col-xl-3">
                        <div class="row">
                           <a href="<?php echo base_url() ?>buyer/myorders/order_view/<?php echo $ord->orders_id; ?>" class="w-100">
                           <img src="<?php echo $details->product_image; ?>" class="mx-auto d-block mb-1 addcartimg">
                           </a>
                        </div>
                     </div>
                     <div class="col-9 col-lg-9 col-xl-9">
                        <div class="d-block text-truncate mb-1">
                           <div class="next-table-cell-wrapper" >
                              <a href="<?php echo base_url() ?>buyer/myorders/order_view/<?php echo $ord->orders_id; ?>" style="text-decoration:none;" title="<?php echo $details->product_name ?>">
                              Product : <?php 
                                 if(strlen($details->product_name) > 23) { 
                                     echo substr($details->product_name, 0, 23).'...';
                                 } else{
                                     echo $details->product_name;
                                  }
                                 ?></a>
                           </div>
                           <a href="<?php echo base_url() ?>buyer/myorders/order_view/<?php echo $ord->orders_id; ?>" class="cartproname">
                              <div class="next-table-cell-wrapper" >
                                 <span>Order No: </span>
                                 <span> #ORD<?php echo $ord->orders_id; ?></span>
                              </div>
                           </a>
                        </div>
                        <div class="seller d-block">
                           <span>Seller: </span>
                           <span><?php echo $seller_info['company_name']; ?></span>
                        </div>
                        <div class="cartviewprice d-block">
                           <span class="amt"><i class="fa fa-inr"></i>.  <?php echo number_format($ord->order_price, 2); ?></span>
                        </div>
                        <div class="d-block">
                           <span class="amt">Date : <?php echo date('d M Y H:i', strtotime($ord->date_purchased)); ?></span>
                        </div>
                        <br>
                     </div>
                  </div>
               </div>
               <div class="col-lg-2 ml-lg-auto align-self-start mt-2 mt-lg-0">
                  <div class="row">
                     <div class="prostatus">
                        <h5 class="del-time" style="margin-top:45px;"><b>Status : </b><?php echo $pr_details[0]->orders_status_name; ?> </h5>
                         <?php   //if stock is not available then don't let buyer to make payment
                         if($low_stock == 0 && strtolower($pr_details[0]->orders_status_name) == 'pending') {
                             echo "<label style='font-weight:bold;font-size:1em;' class='text-danger text-center'>Out Of Stock</label>";
                         }
                         ?>
                     </div>
                  </div>
               </div>
               <div class="col-lg-2 ml-lg-auto align-self-start mt-2 mt-lg-0">
                  <div class="row">
                     <div class="prostatus">
                        <span class="del-time " >
                        <?php //if stock is not available then don't let buyer to make payment
                        if($low_stock != 0) { ?>
                              <a href="<?php echo base_url(); ?>userorder/ship_order/<?php echo $ord->orders_id; ?>" style="margin-top:36px;" class="btn btn-cust btn-sm">Make Payment</a></span>
                         <?php } else {?>
                             <button class = 'notify-class btn btn-cust btn-sm placeorder' style="background: #bd081b;color: #FFF;border-color: #bd081b;"
                                     id="notify_buyer" <?php echo $class ?>
                                     data-id="<?php echo $details->product_id; ?>">Notify Me
                             </button>
                         <?php }?>
                        </span>
                     </div>
                      <div class="prostatus">
                              <span class="del-time " >
                              <a onclick="return confirm('Are You Sure ?');" href="<?php echo base_url(); ?>buyer/myorders/remove_order/<?php echo $ord->orders_id; ?>" class="btn btn-cust btn-sm" style="<?php echo $style; ?>">Remove Order</a></span>
                          </span>
                      </div>
                  </div>
               </div>
            </div>
            <?php
               }
               }
               ?>
         </div>
      </div>
   </div>
</div>
</div>
</div>


</div>
<div id="menu3" class=" tab-pane fade">
   <br>         
   <div class="row">
      <div class="col-lg-12 px-0 pr-lg-2 mb-2 mb-lg-0">
         <div class="card border-light bg-white card proviewcard shadow-sm">
            <div class="card-header">Completed Order</div>
            <div class="card-body">
               <div class="col-lg-12 p-3 cardlist">
                  <div class="col-lg-12">
                     <?php
                        $i = 0;
                        foreach ($allorder as $ord) {
                            //echo'<pre>';
                            //print_r($ord);
                            if ($ord->orders_status == 4) {
                                ?>
                     <div class="row mb-4" style="border-bottom:1px solid #ccc;">
                        <div class="col-lg-8">
                           <div class="row">
                              <?php
                                 $pr_details = $this->Order_model->getOrderDetails($ord->orders_id);
                                 
                                 $seller_info = $this->Product_model->getSellerInformation($pr_details[$i]->seller_id);
                                 
                                 $details = json_decode($pr_details[0]->product_specifications);
                                 ?>
                              <div class="col-3 col-lg-3 col-xl-3">
                                 <div class="row">
                                    <a href="<?php echo base_url() ?>buyer/myorders/order_view/<?php echo $ord->orders_id; ?>" class="w-100">
                                    <img src="<?php echo $details->product_image; ?>" class="mx-auto d-block mb-1 addcartimg">
                                    </a>
                                 </div>
                              </div>
                              <div class="col-9 col-lg-9 col-xl-9">
                                 <div class="d-block text-truncate mb-1">
                                    <div class="next-table-cell-wrapper" >
                                       <a href="<?php echo base_url() ?>buyer/myorders/order_view/<?php echo $ord->orders_id; ?>" style="text-decoration:none;" title="<?php echo $details->product_name ?>">
                                       Product : <?php 
                                          if(strlen($details->product_name) > 23) { 
                                              echo substr($details->product_name, 0, 23).'...';
                                          } else{
                                              echo $details->product_name;
                                           }
                                          ?></a>
                                    </div>
                                    <a href="<?php echo base_url() ?>buyer/myorders/order_view/<?php echo $ord->orders_id; ?>" class="cartproname">
                                       <div class="next-table-cell-wrapper" >
                                          <span>Order No: </span>
                                          <span> #ORD<?php echo $ord->orders_id; ?></span>
                                       </div>
                                    </a>
                                 </div>
                                 <div class="seller d-block">
                                    <span>Seller: </span>
                                    <span><?php echo $seller_info['company_name']; ?></span>
                                 </div>
                                 <div class="cartviewprice d-block">
                                    <span class="amt"><i class="fa fa-inr"></i>.  <?php echo number_format($ord->order_price, 2); ?></span>
                                 </div>
                                 <div class="d-block">
                                    <span class="amt">Date : <?php echo date('d M Y H:i', strtotime($ord->date_purchased)); ?></span>
                                 </div>
                                 <br>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-2 ml-lg-auto align-self-start mt-2 mt-lg-0">
                           <div class="row">
                              <div class="prostatus">
                                 <h5 class="del-time" style="margin-top:45px;"><b>Status : </b><?php echo $pr_details[0]->orders_status_name; ?> </h5>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-2 ml-lg-auto align-self-start mt-2 mt-lg-0">
                           <div class="row">
                              <?php
                                 if ($ord->order_tracking_status == 1) {
                                     $style = "margin-top:15px;margin-bottom:15px;";
                                 } else {
                                     $style = "margin-top:36px;";
                                 }
                                 if ($ord->order_status != 8) {
                                     ?>
                              <div class="prostatus">
                                 <span class="del-time " >
                                 <a href="<?php echo base_url(); ?>buyer/myorders/track_order/<?php echo $ord->orders_id; ?>" class="btn btn-cust btn-sm" style="<?php echo $style; ?>">Track Order</a></span>
                                 </span>
                              </div>
                              <?php
                                 }
                                 
                                 if ($ord->order_tracking_status == 1) {
                                     ?>
                              <?php if ($ord->orders_status_id == 4) { ?> 
                              <a href="<?php echo site_url(); ?>buyer/return_order/index/<?php echo $ord->orders_id; ?>" class="btn btn-cust btn-sm">Help Desk</a> 
                              <?php
                                 } else {
                                     $arr = array(8, 9, 10, 16, 18, 19, 22);
                                     if (in_array($ord->orders_status_id, $arr)) {
                                         ?>
                              <button type="button" class="btn btn-cust btn-sm" data-toggle="modal" data-target="#CancelOrder" value="<?php echo $ord->orders_id; ?>"  onclick="cancel_order(this.value);">Cancel Order</button>
                              <?php }
                                 ?>
                              <?php } ?>
                              <?php } ?>
                           </div>
                        </div>
                     </div>
                     <?php
                        }
                        }
                        ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


</div>
<div id="CancelOrder" class="modal fade"  role="dialog">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" >Cancel Order</h4>
         </div>
         <form class="form-horizontal" action="<?php echo base_url(); ?>buyer/myorders/cancel_order" method="post" id="form_id" >
            <div class="modal-body">
               <p style="color:red;text-align:center;">Note : Shipping Cost will not be Refunded for the Orders being already Picked from the Seller.</p>
               <div class="form-group">
                  <div class="col-md-12">
                     <p id="myOrder"></p>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">Close</button>
               <button type="button" onclick="submit_cancel_order()" class="btn btn-sm btn-info" id="btnSubmit" >Cancel Order</button>
            </div>
         </form>
      </div>
   </div>
</div>
</div>
<br><br><br><br>

<script>
   function cancel_order(ord)
   {
       if (ord != '')
       {
           $.ajax({
               type: 'POST',
               url: '<?php echo base_url(); ?>buyer/myorders/get_order_details',
               data: {'ord': ord},
               success: function (data) {
                   $('#myOrder').html('');
                   $('#myOrder').html(data);
   
               },
               error: function () {
                   alert('Somthing Wrong !');
               }
           });
       }
   }
   
   function submit_cancel_order()
   {
       var reason = $("#reason option:selected").val();
       if (reason == '') {
           $('.reason_error').text('Please Select The Reason!!');
       } else {
           
           var con=confirm('Are You Sure want to Cancel Order ?');
           if(con==true)
           {
               $('#form_id').submit();
           }
       }
   
   }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('.notify-class').click(function () {
            $.post("<?php echo base_url('home_product/add_notify_buyer'); ?>",
                    {product_id: $(this).attr("data-id")})
                    .done(function (data) {
                        if (data == 1) {
                            alert('You have successfully subscribed for notification of this product!')
                        } else if (data == 2) {
                            alert('Already subscribed for notification of this product!');
                        } else {
                            alert();
                        }
                    });
        });
    });
</script>
<script>
jQuery(function ($) {
    $("#allbtninfo ul a") .click(function(e) {
            var link = $(this);		
            var   item = link.parent("li");
			
            if (item.hasClass("active1")) {
                item.removeClass("active1").children("li").removeClass("active1");
            } else {
                item.addClass("active1").children("li").addClass("active1");
            }

            if (item.children("ul").length > 0) {
                var href = link.attr("href");
                link.attr("href", "#");
                setTimeout(function () { 
                    link.attr("href", href);
                }, 300);
                e.preventDefault();
            }
        })
        .each(function() {
            var link = $(this);
            if (link.get(0).href === location.href) {
                link.addClass("active1").parent().find('li').addClass("active1");
				$("#allbtninfo ul").parent().find('li').removeClass('active1');
                return false;
            }
        });
});


</script>
