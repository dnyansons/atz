<?php $this->load->view("mobile/common/header"); ?>
<style>
   .mm-menu_offcanvas {
   display: block; 
   top:9px !important;
   z-index:0;
   }

ai-header .header-wrap, .ai-header .header-wrap, .ai-header-pwa .header-wrap {
    overflow: hidden;
    height: 52px;
    box-shadow: 1px 2px 3px rgba(0,0,0,.3);
    background: #fff;
    display: -webkit-box;
    display: -webkit-flex;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    align-items: center;
    text-align: center;
}
</style>
<div data-comp-name="header">
   <div class="header-wrap">
      <!-- Search Page Start-->
      <ai-header>
         <div class="header-container" style="position: fixed;">
            <div class="header-wrap" ab-test-bucket="">
               <div class="inner ripple rtl-icon" clickevent="back">
                 <a href="<?php echo base_url(); ?>home" class="back-btn">
                  <i class="icon ion-android-arrow-back"></i>
                  </a> 
               </div>
               <div class="master " clickevent="master">
                  <div class="title">
                     <div class="title-placeholder">
                        <!--padding-->
                     </div>
                     <title><?php echo $catname['categories_name']; ?></title>
                  </div>
               </div>
            </div>
         </div>
      </ai-header>
      <!-- mobile menu -->
      <div class=" d-block d-sm-none" style="background:#fff;">
         <!-- multiple slide menu -->
         <div id="page">
            <div class="content" id="categorys-wrapper">
               <!-- mobile view -->
               <nav id="menunew">
                  <ul>
					<?php foreach($categories as $category): ?>
                     <li>
						<a href="<?php echo base_url();?>home/productList/<?php echo $category->category_id; ?>">
							 <?php echo $category->categories_name; ?>
						</a>
                     </li>
					<?php endforeach; ?>
                  </ul>
               </nav>
               <!--machenry navigation -->
            </div>
         </div>
         <!-- mobile view -->
         <!-- mobile view -->
      </div>
      <!-- 4rd -->
   </div>
</div>
<!-- end mobile section -->
<?php $this->load->view("mobile/common/footer"); ?>