
<?php $this->load->view('front/common/header'); ?>
<style>
  .start-trade{
    padding: 100px 0px;
    background-color: #c3f4fd;
    color: #666;
    font-size: 14px;
    line-height: 22px;
  }
  .social-icon{
    font-size: 30px;
    color: #1ab2e8;
    padding: 5px;
  }
  .body-content .section-02 .content .start-btn{
    border: 1px solid #bd081b;
  }
  .body-content .section-05 .get-coverage-btn{
   border: 1px solid #bd081b;
  }

 .banner{
  background:url("<?php echo base_url();?>assets/front/images/trade/image-trade.jpg");
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  height: 400px;
 }
.body-content .section-07 .action-item {
    padding-bottom: 20px;
}

#banner-container .content-wrap .title {
    margin-top: 50px;
}
.content-wrap .title {
    margin-bottom: 5px;
    font-size: 35px;
    line-height: 43px;
}
.answer{
  padding-left: 26px;
}

.sticky {
  position: fixed;
  top: 0;
  width: 100%;
}

</style>
<div id="app">
  <div id="banner-container">
    <div data-reactroot="" id="banner" class="banner">	  
		 <div>
		
			<div class="content-wrap w1200">
				<div class="title">
				 <h1 class="text-center text-white">Trade Assurance</h1>
				</div>
				<div class="subtitle">ATZCart.com free order protection service</div>
			</div>			
		</div>		
     </div>
  <div class="nav " id="navbar">

   <div class="nav-content-wrap flex-layout w1200">
     <i class="icon-ta"></i><span class="title-ta">Trade Assurance</span>
     <div style="position: absolute; right: 0px;">
       <div class="next-nav next-nav-text hoz active bottom">
         <div class="next-menu hoz next-nav-menu sticky-top sticky-offset">
           <ul class="next-menu-content" id="topdown">
            <a class="active" href="#about">
             <li class="next-menu-item next-nav-item ">
               About
             </li>
           </a>
             <a href="#feature">
             <li class="next-menu-item next-nav-item ">
               Features
             </li>
           </a>
           <a href="#faq1">
             <li class="next-menu-item next-nav-item">
               FAQ
             </li>
           </a>
           </ul>
         </div>
       </div>
     </div>
   </div>
 </div>

  <div class="body-content auto-fit" style="background:#fff">
    <!-- section-01 -->
    <div class="section-01" id="section-01">
      <div class="section-content-wrap flex-layout w1200"><img width="100%" height="100%"
          src="assets/front/images/trade/packing.jpg">
        <div class="content" id="about">
          <div class="title">About ATZCart.com</div>
				<div class="desc">
				<h5>Secured online marketplace</h5>
<p>Trade assurance protects your orders; it minimises risk of fraud and assurity in delivering the order with all safety features. ATZCart.com provides 3 tier verification of seller and their services.</p>

<h5>Safe payment options</h5>
<p>A highly secured payment options includes net banking, all types of card payments, and wallet payments. Also buyer can secure their payments with 100% returnable policy under terms and conditions.</p>
				</div>
        </div>
      </div>
    </div>

    <!-- section-02 -->
    <!-- section-03 -->
    <a name="protect"></a>
    <div class="section-03" id="section-03" style="padding-bottom: 40px !important">
      <div class="section-content-wrap w1200" id="feature">
        <div class="title">Features</div>
        <div class="subtitle">Protect your every order for FREE, On time shipping, Quality Protection.</div>
        <div class="flex-layout">
          <div class="imgs" style="margin-top: -40px !important;">
			<img id="shield-frame" width="188px" height="197px" src="assets/front/images/trade/box.png" class="animated fadeInLeft">
			<img  id="parcel" width="264px" height="210px"  src="assets/front/images/trade/box.png"class="animated fadeInRight">

          </div>
          <div class="features flex-layout">
            <div class="column-01">
              <div class="row-01">
                <div class="feature-item flex-layout feature-item-1 animated fadeIn">
				<i class=" iconfont  feature-icon icon ion-social-usd"></i>
                  <div>
                    <div class="feature-title">Payment protection</div>
                    <div class="feature-content">Make payments using our secure.</div>
                  </div>
                </div>
              </div>

              <div class="row-02">
                <div class="feature-item flex-layout feature-item-3 animated fadeIn">
				<i class="iconfont feature-icon icon ion-ios-locked"></i>
                  <div>
                    <div class="feature-title">Shipping protection</div>
                    <div class="feature-content">Your order will be safely shipped at your registered delivery address.</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="column-02">
              <div class="row-01" style="margin-bottom:47px;">
                <div class="feature-item flex-layout feature-item-2 animated fadeIn">
				<i class="iconfont feature-icon icon ion-ios-albums-outline"></i>
                  <div>
                    <div class="feature-title">Product-quality protection</div>
                    <div class="feature-content">Your ordered product will be delivered as displayed and as per your customised selection.</div>

                  </div>
                </div>
              </div>
              <div class="row-02">
                <div class="feature-item flex-layout feature-item-4 animated fadeIn">
				<i class="iconfont feature-icon icon ion-android-checkbox-outline"></i>
                  <div>
                    <div class="feature-title">Protection period</div>
                    <div class="feature-content">Your order will be protected up to 10 days from the day of delivery/shipment.
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- section-07 -->
    <div class="section-07" id="section-07" data-aplus-ae="x7_332dc6e6">
	<div class="section-content-wrap flex-layout w1200" id="faq1" style="padding-top: 63px;">
        <div class="actions">
          <div class="action-item">
            <div class="title">FAQ</div>
            <div class="content">
              You can find all Frequently Asked Questions in our

              <br><a href="<?php echo base_url(); ?>help-center" style="color:#0066CC;">Help Center</a></div>

          </div>
          <div class="action-item">
            <div class="title">Terms</div>
            <div class="content">
              Read the full Trade Assurance

              <a  href="<?php echo base_url(); ?>policies-rules" style="color:#0066CC;">terms of service</a></div>

          </div>

        </div>
        <div class="faqs">
          <div class="faq-item">
            <div class="question">Q: Trade assurance charge me for every order?</div>
            <div class="answer">No, its free of cost for buyers.</div>
          </div>
          <div class="faq-item">
            <div class="question">Q: How to confirm order is covered under trade assurance?</div>
            <div class="answer">
             Every order covers trade assurance service.

            </div>
          </div>


        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('front/common/footer'); ?>

<script>
$(document).ready(function(){
  // Add smooth scrolling to all links
  $("#topdown a").on('click', function(event) {

    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, function(){

        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
});
window.onscroll = function() {myFunction()};
var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
</script>
