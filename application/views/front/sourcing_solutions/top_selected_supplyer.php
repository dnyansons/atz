<?php $this->load->view('front/common/header'); ?>
<style>
    @import url(assets/front/css/new-style.css);

    body {
        background: #f3f3f3;
    }

    #wrapper {
        padding: 50px 15px;
    }

    .card {
        margin-bottom: 15px;
        border-radius: 0;
        box-shadow: 0 3px 5px rgba(0, 0, 0, .1);
    }

    .card-title {
        font-size: 20px
    }

    @media(min-width:992px) {
        .leftmenutrigger {
            display: block;
            display: block;
            margin: 7px 20px 4px 0;
            cursor: pointer;
        }

        #wrapper {
            padding:50px 15px 15px 75px;
        }

        #wrapper.open {
            padding: 90px 15px 15px 225px;
        }

        .side-nav li a {
            padding: 20px
        }

        .navbar-nav li a .shortmenu {
            float: right;
            display: block;
            opacity: 1
        }

        .navbar-nav.side-nav.open.navbar-nav li a .shortmenu {
            opacity: 0
        }

        .navbar-nav.side-nav {
            background: #585f66;
            box-shadow: 2px 1px 2px rgba(0, 0, 0, .1);
            position: fixed;
            top: 56px;
            flex-direction: column !important;
            left: -140px;
            width: 200px;
            bottom: 0;
            padding-bottom: 40px
        }
    }

    .animate {
        -webkit-transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        -ms-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out
    }

    .navbar-nav li a svg {
        font-size: 25px;
        float: left;
        margin: 0 10px 0 5px;
    }

    .side-nav li {
        border-bottom: 1px solid #50575d;
    }

    .side-nav .dropdown {
        position: initial;
    }

    .side-nav .dropdown-menu {
        position: relative;
        opacity: 0;
        left: 120%;
        top: 0;
        height: 100%;
        border: 0;
        padding: 0;
        margin: 0;
        border-radius: 0;
        box-shadow: 5px 0 5px rgba(0, 0, 0, .1);
        background: #eee;
        visibility: hidden;
        display: block;
        transition: .4s ease all;
    }

    .side-nav .dropdown-menu.show {
        left: 100%;
        opacity: 1;
        visibility: visible;
        display: block;
        transition: .4s ease all;
    }

    .selection-detailed-title .title {
        font-size: 32px;
        color: #333;
        line-height: 36px;
        font-family: Roboto;
        text-align: center;
    }

    
    
  .ion-chevron-left,.ion-chevron-right {
   
    background: rgba(0, 0, 0, 0.5);
    padding: 10px 5px;
}
    #demo
    {
     width:700px; margin:-80px auto;
     margin-bottom:30px;
    }
	
	
	.icon-layers
	{
		font-size:80px;
	}
	
	.features-icons-item h3
	{
      font-size:20px;
	  font-weight:100px;
	  margin-top:15px;
	 
	}
	
	.features-icons-item 
	{	
	 box-sizing: border-box;
	 background:#fff;
	 padding:20px;
	}
	
	
	
	
	

/* Slider */

.slick-slide {
    margin: 0px 0px;
}

.slick-slide img {
    width: 100%;
}

.slick-slider
{
    position: relative;
    display: block;
    box-sizing: border-box;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
            user-select: none;
    -webkit-touch-callout: none;
    -khtml-user-select: none;
    -ms-touch-action: pan-y;
        touch-action: pan-y;
    -webkit-tap-highlight-color: transparent;
}

.slick-list
{
    position: relative;
    display: block;
    overflow: hidden;
    margin: 0;
    padding: 0;
}
.slick-list:focus
{
    outline: none;
}
.slick-list.dragging
{
    cursor: pointer;
    cursor: hand;
}

.slick-slider .slick-track,
.slick-slider .slick-list
{
    -webkit-transform: translate3d(0, 0, 0);
       -moz-transform: translate3d(0, 0, 0);
        -ms-transform: translate3d(0, 0, 0);
         -o-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
}

.slick-track
{
    position: relative;
    top: 0;
    left: 0;
    display: block;
}

.slick-prev:before
{
	content: "<";
    background:rgba(0,0,0,0.5);
    padding: 10px 4px;
    justify-content: center;
    text-align: center;
    align-items: center;
    display: flex;
}

.slick-next:before
{
	content: ">";
    background:rgba(0,0,0,0.5);
    padding: 10px 4px;
    justify-content: center;
    text-align: center;
    align-items: center;
    display: flex;
}
.slick-track:before,
.slick-track:after
{
    display: table;
    content: '';
}
.slick-track:after
{
    clear: both;
}
.slick-loading .slick-track
{
    visibility: hidden;
}

.slick-slide
{
    display: none;
    float: left;
    height: 100%;
    min-height: 1px;
}
[dir='rtl'] .slick-slide
{
    float: right;
}
.slick-slide img
{
    display: block;
}
.slick-slide.slick-loading img
{
    display: none;
}
.slick-slide.dragging img
{
    pointer-events: none;
}
.slick-initialized .slick-slide
{
    display: block;
}
.slick-loading .slick-slide
{
    visibility: hidden;
}
.slick-vertical .slick-slide
{
    display: block;
    height: auto;
    border: 1px solid transparent;
}
.slick-arrow.slick-hidden {
    display: none;
}
</style>
<div id="app">
   <div>
        <div class="pz-page">	
			<header style="background:url(<?php //echo base_url();?>assets/front/images/banner/top.jpg)no-repeat top; background-size:cover; height:350px;">
			  <div class="overlay"></div>  
			  <div class="container h-100">
				<div class="d-flex h-100 text-center align-items-center">
				  <div class="w-100 text-white">
					<h1 class="display-3">Know More, Source Better</h1>
					
				  </div>
				</div>
			  </div>
			</header>
		</div>	
        <!-- 
            <div id="demo" class="carousel slide" data-ride="carousel">
            
                <div class="carousel-inner">
                <?php //if($result){
                    //$i=0;
                   // foreach($result as $row){
                    //$i++;
                   // if($i == 1)
                    //{
                   //     $active = "active";
                   // }else{
                   //     $active = "";
                   // }
                 ?>
                    <div class="carousel-item <?php// echo $active; ?> " >
                      <div class="row">
                       
                        <div class="col-md-12">
                          <div class="col">
                            <div class="card">
                                <div class="card-body">            
                                    <div class="supplier-wrap">
                                      <div class="supplier-box">
                                         <div class="data-show">
                                            <span>Completed</span>
                                         </div>
                                         <div class="data-show">
                                            <span class="number"><?php //echo $row['orders_count']; ?></span><span>orders </span>
                                         </div>
                                        
                                        
                                         <div class="footer">
                                            <div class="photo" style="background-image: url(<?php //echo base_url();?>assets/front/images/trade/user.png);"></div>
                                            <div class="infomation">
                                               <div class="name"> <?php //echo $row['first_name']; ?> <?php// echo $row['last_name']; ?></div>
                                               <div class="position"><?php //echo $row['role']; ?></div>
                                               <div class="qualifation">
                                                  <a class="icbu-icon-gs-year icbu-icon-gs-year-bg icbu-icon-gs-year-small" href="">
                                                   
                                                     <?php //$current_year = date('Y');
                                                        //$year_of_register = $current_year-$row['year_of_register']; 
                                                       ?>
                                                     <span class="join-year"><span class="value"><?php// echo $year_of_register; ?></span><span class="unit">YRS</span></span>
                                                  </a>
                                                <img src="">
                                                  <span class="company"><?php //echo $row['company_name']; ?></span>
                                               </div>
                                            </div>
                                           
                                         </div>
                                         <form action="" target="_blank"></form>
                                      </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        
                      </div> 
                  </div>
                 <?php //} }?>
                </div>

               
                <a class="carousel-control-prev" href="#demo" data-slide="prev">
                  
                  <i class="icon ion-chevron-left"></i>
                </a>
                <a class="carousel-control-next" href="#demo" data-slide="next">
                
                  
                  <i class="icon ion-chevron-right"></i>
                </a>
              </div>
    	  </div>
    </div>
	-->
	
 <section class="features-icons text-center mt-50 mb-50 ">
    <div class="container">
	<h1 class="h2 mb-70">How Suppliers are listed as Top Supplier? </h1>
      <div class="row">
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
             <i class="fa fa-clock-o fa-3x icon-layers m-auto text-primary" aria-hidden="true"></i>
            </div>
            <h3>Minimum Response Time</h3>
           
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
             
			  <i class="fa fa-globe fa-3x  icon-layers m-auto text-primary" aria-hidden="true"></i>
            </div>
            <h3>Maximum Trade Records</h3>
            
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
             
			  <i class="fa fa-truck fa-3x m-auto icon-layers text-primary" aria-hidden="true"></i>
            </div>
            <h3>Maximum exports</h3>
           
          </div>
        </div>
      </div>
    </div>
  </section>
   
  <div class="container p-0 mb-5">  
   <section class="customer-logos slider">   
           <?php if($result){
                    $i=0;
                    foreach($result as $row){
                    $i++;
                    if($i == 1)
                    {
                        $active = "active";
                    }else{
                        $active = "";
                    }
                 ?>
     
            <div class="slide">                   
                      <div class="row">                       
                        <div class="col-md-12">
                          <div class="col">
                            <div class="card">
                                <div class="card-body">            
                                    <div class="supplier-wrap">
                                      <div class="supplier-box">
                                         <div class="data-show">
                                            <span>Completed</span>
                                         </div>
                                         <div class="data-show">
                                            <span class="number"><?php echo $row['orders_count']; ?></span><span>orders </span>
                                         </div>
                                        
                                        
                                         <div class="footer">
                                            <div class="photo" style="background-image: url(<?php echo base_url();?>assets/front/images/trade/user.png);"></div>
                                            <div class="infomation">
                                               <div class="name"> <?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?></div>
                                               <div class="position"><?php echo $row['role']; ?></div>
                                               <div class="qualifation">
                                                  <a class="icbu-icon-gs-year icbu-icon-gs-year-bg icbu-icon-gs-year-small" href="">
                                                   
                                                     <?php $current_year = date('Y');
                                                        $year_of_register = $current_year-$row['year_of_register']; 
                                                       ?>
                                                     <span class="join-year"><span class="value"><?php echo $year_of_register; ?></span><span class="unit">YRS</span></span>
                                                  </a>
                                                <img src="">
                                                  <span class="company"><?php echo $row['company_name']; ?></span>
                                               </div>
                                            </div>
                                           
                                         </div>
                                         <form action="" target="_blank"></form>
                                      </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        
                      </div> 
                 
               
                
	        </div>
     <?php } }?>
     
   </section>
</div>

</div>

<?php $this->load->view('front/common/footer'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
<script>
$(document).ready(function(){
    $('.customer-logos').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1500,
        arrows: true,
        dots: false,
        pauseOnHover: false,
        responsive: [{
            breakpoint: 768,
            settings: {
                slidesToShow: 4
            }
        }, {
            breakpoint: 520,
            settings: {
                slidesToShow: 1
            }
        }]
    });
});
</script>