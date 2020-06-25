<?php $this->load->view('front/common/header'); ?>

<style>
.btn1{     
	box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
    padding: .84rem 2.14rem;
    font-size:1.2rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    margin: .375rem;
    border: 0;
    border-radius: .125rem;
    cursor: pointer;
    text-transform: uppercase;
    white-space: normal;
    word-wrap: break-word;    
	background:#bd081b;
	color:#fff !important;
	font-weight:700;
	border-radius:20px;
}
.btn2{    
	box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
    padding: .84rem 2.14rem;
    font-size:1.2rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    margin: .375rem;
    border: 0;
    border-radius: .125rem;
    cursor: pointer;  
    white-space: normal;
    word-wrap: break-word;
    color: #fff !important;
	font-weight:700;
	background:#00002c;
	border-radius:20px;
}
.shadow1{box-shadow:0 1px 4px rgba(0, 0, 0, 0.1), 0 0 40px rgba(0, 0, 0, 0.1);}
</style>

<!-- Header -->
<header class="text-center p-5 mb-4" 
style=" background:url('<?php echo base_url();?>assets/front/images/help/help.jpg') center no-repeat;margin-left: auto;margin-right: auto;text-align: center;width: 100%; height:250px;">
 
</header>

<!-- Page Content -->
<div class="container mb-5">

  <h1 class="py-3 h2 text-center" style="color:#00002c;"> <i>Hello,</i> we are happy to assist you! </h1>
  
  <div class="row">
    <!-- Team Member 1 -->
     <!-- Team Member 2 -->
    <div class="col-xl-6 col-md-6 mb-4 text-center">
      <div class="card border-0 p-5 m-5 text-center shadow1" >
        <p><img src="<?php echo base_url();?>assets/front/images/icons/support.svg" width="70" class="" alt="..."></p>
		
        <div class="card-body text-center">
         <p class="card-title mb-0" style="font-size:16px;">Our customer care support helps you to assists on your query 24X7</p>
         </div>
		
		<a class="btn1 active" role="button" aria-pressed="true">1800-212-2036 </a>
      </div>
	  <br><br><br><br>		
    </div>
    <!-- Team Member 3 -->
	
    <!-- Team Member 2 -->
    <div class="col-xl-6 col-md-6 mb-4 text-center">
      <div class="card border-0 p-5 m-5 text-center shadow1" >
        <p>
		<img src="<?php echo base_url();?>assets/front/images/icons/letter.svg" width="70" class="rounded" alt="..."></p>
		
        <div class="card-body text-center">
          <p class="card-title mb-0" style="font-size:16px;">
		  Feel free to write us your queries reviews or any product related feedback on </p>
         
        </div>		
		<a class="btn2 active" role="button" aria-pressed="true">helpdesk@atzcart.com</a>
      </div>
	  <br><br>
	   
    </div>
    <!-- Team Member 3 -->

  </div>
  <!-- /.row -->

</div>
<!-- /.container -->


<!--
<div class="container bg-color">
	
			<h5 class="text-center support">Contact ATZCart.com Support</h5>
	<div class="row">
		<div class="col-xs-12 col-md-6 col-sm-6 text-center pdt50">
			<div class="img_contact">
				<img class="rounded-circle" src="<?php echo base_url();?>assets/front/images/logo/byer.jpg">
			</div>
			<div class="heading">
			   <h5>
			   	I'm a buyer on ATZCart.com
			   </h5> 
			</div>
			<div class="buttons">
				<button type="button" class="btn btn-primary">Chat</button>
				<button type="button" class="btn btn-success btn-md">Call us - 1800-212-2036 </button>
			</div>

		</div>
		<div class="col-xs-12 col-md-6 col-sm-6 text-center heading"> 
			<div class="img_contact">
				<img class="rounded-circle" src="<?php echo base_url();?>assets/front/images/logo/seller.jpg">
			</div>
			<div class="heading">
			   <h5>
			   	I'm a seller on ATZCart.com
			   </h5> 
			</div>
			<div class="buttons">
				<button type="button" class="btn btn-primary btn-md"> Chat </button>
				<button type="button" class="btn btn-success btn-md">Call us- 1800-212-2036 </button>
			</div>
		</div>
			
		</div>
</div>-->

<?php $this->load->view('front/common/footer'); ?>
