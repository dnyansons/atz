<html>
   <head>
	<title>ATZ Cart</title>
	<meta charset="utf-8">     
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">     
	<meta name="google-site-verification" content="nP5Df-TYNWX_nGB7Qum5d5I4cXzd3E7A2TXtZ0Y2x_Q" /> 
        <link href="<?php echo base_url(); ?>assets/mobile/mobile/send-enq.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/ionicons.min.css">
     
     <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/bootstrap.min.css"> -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-144123824-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-144123824-1');
</script>

<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '318941032348543'); 
fbq('track', 'PageView');
</script>

<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=318941032348543&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->

<!-- Global site tag (gtag.js) - Google Ads: 728750276 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-728750276"></script>
<script>
 window.dataLayer = window.dataLayer || [];
 function gtag(){dataLayer.push(arguments);}
 gtag('js', new Date());

 gtag('config', 'AW-728750276');
</script>
        <style>
	ai-header .icon, .ai-header .icon, .ai-header-pwa .icon {
		font-size: 24px;
		color: #696969;
		display: inline-block;
		vertical-align: middle;
		top: 29px;
		padding-top: 15px;
	}
.alert {
    position: relative;
    padding: .75rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: .25rem;
  }

  .alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.alert-dismissible {
    padding-right: 4rem;
}

	</style>	  
   </head>
   <body>
      <ai-header>
         <div class="header-container" style="position: fixed;">
            <div class="header-wrap" ab-test-bucket="">
              <div class="inner ripple">
				  <a href="<?php echo base_url(); ?>product/productOverview/<?php echo $productinfos['id']; ?>"><i class="icon ion-android-close"></i>	</a>
						</div>
               <div class="master " clickevent="master">
                  <div class="title">
                     <div class="title-placeholder">
                        <!--padding-->
                     </div>
                     <title>Post Buying Request</title>
                  </div>
               </div>
            </div>
         </div>
      </ai-header>

      <div id="page" class="content" data-page-id="myalibaba-rfq-send">
          <p id='success_msg'><?php echo $this->session->flashdata('message'); ?></p>
         <form id="form-rfq-send" action="<?php echo base_url(); ?>rfq/insertRfq" method="post" enctype="multipart/form-data">
			<input type="hidden" name="product_id" value="<?php echo $productinfos['id']; ?>">
            <section class="row wf-product-name">
               <div class="underline-wrap err-pop">
                  <input type="text" name="pname" value="<?php echo $productinfos['name']; ?>" id="f-product-name" required="required">
                  <label class="underline"><i>Product Name</i></label>
               </div>
            </section>
            <section class="row wf-order-quantity">
               <div class="wrap-group">
                  <div class="wrap">
                     <div class="wrap-quantity err-pop underline-wrap">
                        <input type="number" name="quantity" value="<?php echo $productinfos['name']; ?>" id="f-quantity" required="required">
                        <label class="underline"><i>Quantity</i></label>
                     </div>
                  </div>
                  <div class="wrap">
                     <label for="f-unit">Unit</label>
                     <div class="wrap-unit err-pop">
                        <select name="unit" value="" id="f-unit">
			<?php foreach($units as $unit) : ?>
                           <option value="<?php echo $unit->units_name; ?>"><?php echo $unit->units_name; ?></option>
			<?php endforeach; ?>
                        </select>
                        <i for="f-unit" class="iconfont-caret-down"></i>
                     </div>
                  </div>
               </div>
            </section>
			
            <section class="row wf-product-spec">
               <div class="underline-wrap err-pop">
                  <textarea name="details" onkeyup="charcountupdate(this.value)" value="" id="f-product-spec" required="required"></textarea>
                  <label class="underline"><i>Details</i></label>
               </div>
               <label class="words-sum" id="charcount">0/800</label>
            </section>
			 
            <section class="row wf-relevant-file">
                <div id="gallery" style="float:left"></div>
                   <div id="" class="clearfix">	 
                    <a id="file1" class=" " data-order="0" href="javascript:void(0)">
                        <input type="file" name="quote_attachment[]" multiple="multiple" id="gallery-photo-add">
                    </a>		
                   </div><br>		   
<!--               <div class="tip">
                  Max. 3 attachements. Max. 3MB for each image.
               </div>-->
            </section>
            <section class="row action">
               <button class="btn-send ui-btn ripple" type="submit" name="event_submit_do_perform">SUBMIT</button>
            </section>
            <section class="row wf-order-quantity">
               <label for="field-buyerinfoprotection">
               <input type="checkbox" id="field-buyerinfoprotection" name="shareConsent" value="1" checked="checked">
               <span class="declaration">I agree to share my contact information in my Buyer Profile with suppliers who quote Buying Requests.</span>
               </label>
            </section>
      </div>
      </form>
	  <script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.2.1.min.js"></script> 
	  <script>
				$(function() {
				// Multiple images preview in browser
				var imagesPreview = function(input, placeToInsertImagePreview) {

					if (input.files) {
						var filesAmount = input.files.length;

						for (i = 0; i < filesAmount ; i++) {
							var reader = new FileReader();
							reader.onload = function(event) {
								$($.parseHTML('<img class="img-responsive" style="width:88px;height:88px;">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
							}
							reader.readAsDataURL(input.files[i]);
						}
					}

				};
				
				$('#gallery-photo-add').on('change', function() {
					imagesPreview(this, '#gallery');
                                        
                                         var files = $(this)[0].files;
                                        if(files.length > 6){
                                            alert("you can select max 6 files.");
                                            location.reload(true);
                                            return false;
                                        }else{
                                            //alert("correct, you have selected less than 10 files");
                                            return true;
                                        }
    
				});
			});
			 function charcountupdate(str) {
				var lng = str.length;
				//alert("hi");
				document.getElementById("charcount").innerHTML = lng + ' / 800';
			}

			
	  </script>
	  
	 
   </body>
</html>