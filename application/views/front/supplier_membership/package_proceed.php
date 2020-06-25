<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>aTz || Largest online B2B marketplace </title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?php echo base_url();?>assets/admin/images/favicon.ico" type="image/x-icon">
	<title>aTz || Largest online B2B marketplace </title>
	<!--<link rel="icon" type="image/x-icon" href="assets/front/images/icons/icon_logo.png"> -->	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/ionicons.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/css-plugins-call.css">		
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/main.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/responsive.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/colors.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/demo.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/jquery.mmenu.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/swiper.min.css">	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/all-comman.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/bundle.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/css/reset.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/css/jquery-picZoomer.css">


	
</head>

<body style="background:#f3f3f5 url(src/assets/front/images/back.png);background-repeat: no-repeat;" id="overlay">
<div class="d-block d-sm-none">
  <div class="header-wrap demonavheader">
    <div class="site-header with-shadow">
      <div class="main-header">
        <a class="header-item btn-search " onclick="openNav()"><i class="fa fa-bars"></i></a>
        <a class="header-item logo" href="/"><img src="<?php echo base_url(); ?>assets/front/images/logo/logo.png" alt=""></a>
      </div>
      <div class="search-text">
        <div class="search-bar">
          <div class="searchbar">
            <input class="search_input" type="text" name="" placeholder="Search...">
            <a href="#" class="search_icon"><i class="fa fa-search"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

 <div class="main">
<?php //if($pending_order=='Accepted') { ?>
<form name="razorpay-form" id="razorpay-form" action="<?php echo $return_url; ?>" method="POST">
 
  <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" />
  <input type="hidden" name="merchant_pkg_id" id="merchant_order_id" value="<?php echo $merchant_pkg_id; ?>"/>
  <input type="hidden" name="merchant_trans_id" id="merchant_trans_id" value="<?php echo $txnid; ?>"/>
  <input type="hidden" name="merchant_product_info_id" id="merchant_product_info_id" value="<?php echo $productinfo; ?>"/>
  <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $surl; ?>"/>
  <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $furl; ?>"/>
  <input type="hidden" name="card_holder_name_id" id="card_holder_name_id" value="<?php echo $card_holder_name; ?>"/>
  <input type="hidden" name="merchant_total" id="merchant_total" value="<?php echo $total; ?>"/>

</form>
<?php// } ?>
<div id="draft" class="draft">
 
    <div>
      <a href="<?php echo base_url(); ?>"><div id="brandIntro_1" class="brand-intro" style="height: 20px;">
       <h2><img style="width:200px;" src="<?php echo base_url(); ?>assets/front/images/logo/logo.png"> &nbsp;&nbsp;Supplier Membership Proceed </h2></a>
      </div>
    </div>
    <br>
    <div>
      <div class="next-step next-step-arrow next-step-horizontal base-step draft-stepBlock stepBlock_1">
        <div data-spm-click="gostr=/sc.1;locaid=d_step;step=Start Order" class="next-step-item  next-step-item-first"
          style="width: auto;">
          <div class="next-step-item-container">
            <div class="next-step-item-title">Make Payment</div>
          </div>
        </div>
	
      </div>
    </div>
    <br>
	
    <div>
	<?php 
	if(!empty($pkg_id))
	{
	
?>	
		<div class="ui2-feedback ui2-feedback-large ui2-feedback-success notice" data-spm="notice" data-spm-anchor-id="a2700.8267363.0.notice.7b673e5fRsiKW0">
   
    
    <div class="ui2-feedback-content">
	<div style="text-align:center;">
       <table class="table table-bordered table-center">
	   <tr>
	   <th>Package </th>
	   <td><?php echo $pkg_name; ?></td>
	   </tr>
	   <tr>
	   <th>Duration</th>
	  <td><?php echo $duration; ?></td>
	   </tr>
	   <tr>
	   <th>Price</th>
	   <td><?php echo number_format($amount,2); ?></td>
	   </tr>
	   </table>
        
    </div>
	
	 <input class="next-btn next-btn-primary next-btn-large biz-action-bar-button pull-right" id="submit-pay" type="submit" onclick="razorpaySubmit(this);" value="Proceed to Pay" class="btn btn-primary"/>
	 <hr>
    </div>
</div>
	<?php
	}
else{
	redirect('supplier_membership');
}	
	?>

	
	
	
	
      
    </div>

</div>
</div>
</div>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
  var razorpay_options = {
    key: "<?php echo $key_id; ?>",
    amount: "<?php echo $total; ?>",
    name: "<?php echo $name; ?>",
    description: "Package  # <?php echo $pkg_name; ?>",
    netbanking: true,
    currency: "<?php echo $currency_code; ?>",
    prefill: {
      name:"<?php echo $card_holder_name; ?>",
      email: "<?php echo $email; ?>",
      contact: "<?php echo $phone; ?>"
    },
    notes: {
      soolegal_order_id: "<?php echo $merchant_pkg_id; ?>",
    },
    handler: function (transaction) {
		
        document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
        document.getElementById('razorpay-form').submit();
    },
    "modal": {
        "ondismiss": function(){
            location.reload()
        }
    }
  };
  var razorpay_submit_btn, razorpay_instance;

  function razorpaySubmit(el){
    if(typeof Razorpay == 'undefined'){
      setTimeout(razorpaySubmit, 200);
      if(!razorpay_submit_btn && el){
        razorpay_submit_btn = el;
        el.disabled = true;
        el.value = 'Please wait...';  
      }
    } else {
      if(!razorpay_instance){
        razorpay_instance = new Razorpay(razorpay_options);
        if(razorpay_submit_btn){
          razorpay_submit_btn.disabled = false;
          razorpay_submit_btn.value = "Pay Now";
        }
      }
      razorpay_instance.open();
    }
  }  
</script>