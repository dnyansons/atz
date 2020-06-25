<?php $this->load->view("front/common/header"); ?>
<style>
.maincard {
box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .16), 0 2px 10px 0 rgba(0, 0, 0, .12);
border: 0;
font-weight: 400;
}
.payment_option .card_main{
background:#bd081b;
	color:#fff;    	  
}
.payment_option .card-header{
	padding:.7rem 1rem;
}
.payment_option .card-header h5{
	background:none;
}
.payment_option .card_main p{
	color:#fff;	
	text-transform:uppercase;
	font-weight:600;	  
}
.payment_option .card-body{
	padding:0px !important;
}
.credit input{
	border-radius:0px;
	height:40px;
}
.btn {
	box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
	padding: .4rem 2.14rem;
	color:#fff;
	font-size:1.3rem;
	transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
	border: 0;
	border-radius: .125rem;
	cursor: pointer;
	text-transform: uppercase;
	white-space: normal;
	word-wrap: break-word;
	color: #fff;
}
.waves-effect {
	position: relative;
	cursor: pointer;
	overflow: hidden;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
	-webkit-tap-highlight-color: transparent;
}

.maincard1{	
	border: 0 !important;
}
.maincard1 .card-header {
	border-top: 1px solid rgba(0,0,0,.1) !important;
	border-radius: 0 !important;
	background:#fff !important;
	border-bottom:0px !important;

	}
	.align-items{
		text-align:center!important;
	}
	#success-message {
		background-color:#d4edda;color:#155724;border-color:#c3e6cb;
	}
	#error-message {	
		background-color:#f8d7da;color:#721c24;border-color:#f5c6cb;
	}

</style>

<main class="pt-4">
    <div class="container">
        <!--Grid row-->
        <div class="row">
            <!--Grid column-->
            <div class="col-md-8 mb-4">
                <!-- pending -->
                <!--Card: Main question-->
                <div class="question-card payment_option card mb-4 maincard">
                    <!-- Card header -->
                    <div class="card-header card_main forum-card-img-30 d-flex justify-content-between">
                        <p class="pt-2 mb-0"> Payment Options  </p>                       
                    </div>
                   <form action="<?= base_url('welcome/payment_process')?>" method="post" novalidate="" name="customerData" class="credit" id="paymentForm">

				  <input type="hidden" name="tid" id="tid" readonly />		
				  <input type="hidden" name="merchant_id" value="224525"/>
				  <input type="hidden" name="order_id" value="<?=$merchant_order_id ?>"/>
				  <input type="hidden" name="amount" value="<?= $total?>" />
				  <input type="hidden" name="currency" value="INR"/>
				  <input type="hidden" name="redirect_url" value="<?=base_url().'welcome/success'?>"/>
				  <input type="hidden" name="cancel_url" value="<?=base_url().'welcome/failed'?>"/>
				  <input type="hidden" name="language" value="EN"/>			  	
				  <input type="hidden" name="billing_name" value="Charli"/>
				  <input type="hidden" name="billing_address" value="Room no 1101, near Railway station Ambad"/>
				   <input type="hidden" name="billing_city" value="Indore"/>
				   <input type="hidden" name="billing_state" value="MH"/>
				   <input type="hidden" name="billing_zip" value="425001"/>
				   <input type="hidden" name="billing_country" value="India"/>
				   <input type="hidden" name="billing_tel" value="9999999999"/>
				   <input type="hidden" name="billing_email" value="test@test.com"/>

				   <input type="hidden" name="delivery_name" value="Chaplin"/>
				   <input type="hidden" name="delivery_address" value="room no.701 near bus stand"/>
				    <input type="hidden" name="delivery_city" value="Hyderabad"/>
				    <input type="hidden" name="delivery_state" value="Andhra"/>
				    <input type="hidden" name="delivery_zip" value="425001"/>
				    <input type="hidden" name="delivery_country" value="India"/>
				    <input type="hidden" name="delivery_tel" value="5555555555"/>
                  	
                  	<input type="hidden" name="merchant_param1" value="additional Info."/>
                  	<input type="hidden" name="merchant_param2" value="additional Info."/>
                  	<input type="hidden" name="merchant_param3" value="additional Info."/>
                  	<input type="hidden" name="merchant_param4" value="additional Info."/>
                  	<input type="hidden" name="merchant_param5" value="additional Info."/>

				  <input type="hidden" id="card_type" name="card_type" value="" readonly="readonly"/>
					  <input type="hidden" name="payment_name" id="payment_name">
				    <!--Card content-->
                    <div class="card-body">
                        <!--Accordion wrapper-->
					<div class="accordion md-accordion accordion-blocks" id="accordionEx78" role="tablist" aria-multiselectable="true">

					  <!-- Accordion card -->
					   <!--credit card -->
					  <div class="card maincard1">
						<!-- Card header -->
						<div class="card-header p-3" role="tab" id="headingUnfiled">
						  <div data-toggle="collapse" data-parent="#accordionEx78" href="#collapseUnfiled" aria-expanded="true"
							aria-controls="collapseUnfiled">
							<h5 class="mt-1 mb-0">
							<span> <!-- Group of material radios - option 1 -->
				                  <div class="custom-control custom-radio">
									  <input type="radio" class="custom-control-input payOption" id="defaultGroupExamplecredit" name="payment_option" checked value="OPTCRDC">
									  <label class="custom-control-label" for="defaultGroupExamplecredit">Credit Card</label>
								   </div>
								
							</span>							  
							</h5>
						  </div>
						</div>

						<!-- Card body -->
						<div id="collapseUnfiled" class="collapse show cardP" role="tabpanel" aria-labelledby="headingUnfiled"
						  data-parent="#accordionEx78">
						  <div class="card-body">
							  <div class="m-4">
							    <!--Top Table UI-->
								  <div class="row">
								  	<div class="col-12 my-2">
								     <div class="form-group">
										<label for="cc-number" class="control-label mb-1">Select Card</label>
										 <select name="card_name" class="form-control credit_card_name" id="card_name"> 
										 </select>
									  </div>
									</div>
								</div>
								<div class="row">
								    <div class="col my-2">
								     <div class="form-group">
										<label for="cc-number" class="control-label mb-1">
										Card number</label>
										<span class="input-group-prepend">
									      <span class="input-group-text">
									        <i class="fa fa-credit-card"></i>
									      </span>
									      	<input id="card_number" name="card_number" type="text" class="form-control cc-exp" required placeholder="Card Number" autocomplete="card_number" inputmask="'mask': '9999 9999 9999 9999'"  />
									    </span>
								
										<span class="invalid-feedback">Enter a valid 16 digit card number
									</span>
									  </div>
									</div>
									<div class="col my-2">
											<div class="form-group">
												<label for="cc-exp" class="control-label mb-1">Expiry Month</label>
												<span class="input-group-prepend">
												 <span class="input-group-text">
											        <i class="fa fa-calendar"></i>
											     </span>

												<input id="expiry_month" name="expiry_month" type="text" class="form-control cc-exp" required placeholder="MM" maxlength="2" autocomplete="expiry_month" inputmask="'mask': '99'"/>
												</span>
												<span class="invalid-feedback">Enter the expiration month</span>
											</div>
										</div>
								</div>
									  
									  <div class="row">
										<div class="col my-2">
											<div class="form-group">
												<label for="cc-exp" class="control-label mb-1">Expiry Year</label>
												<span class="input-group-prepend">
												<span class="input-group-text">
											        <i class="fa fa-calendar"></i>
											     </span>
												<input id="expiry_year" name="expiry_year" type="text" class="form-control cc-exp" required placeholder="YYYY" maxlength="4" autocomplete="expiry_year" />
											</span>
												<span class="invalid-feedback">Enter the expiration Year</span>
											</div>
										</div>

										<div class="col my-2">
											<label for="cvv_number" class="control-label mb-1">CVV</label>
											<div class="input-group">
												<input id="cvv_number" name="cvv_number" type="text" class="form-control cc-exp" maxlength="3" placeholder="CVV" required autocomplete="off" value="328">
												<span class="invalid-feedback order-last">
												Enter the 3-digit code on back</span>
												<div class="input-group-append">
												<div class="input-group-text">
												<span class="fa fa-question-circle fa-lg"></span>
												</div>
												</div>
											</div>
										</div>	


									</div>
										<div id="success-message"></div>
										<div id="error-message"></div>
										<div class="col my-2">
										<label for="x_card_code" class="control-label mb-1"></label>
										<button id="payment-button" type="submit" class="btn btn-lg btn-danger btn-block">
											&nbsp;
											<span id="payment-button-amount">Pay $100</span>
											<!-- <span id="payment-button-sending" style="display:none;">Sending…</span> -->
										</button>
										
									   </div>
									</div>
								
                            </div>
						  </div>
						</div>
					  </div>
					  <!-- Accordion card -->
					  <!--debit card -->

					   <div class="card maincard1">
						<!-- Card header -->
						<div class="card-header" role="tab" id="heading79">
						  <!--Options-->
						<!-- Heading -->
						  <div data-toggle="collapse" data-parent="#accordionEx78" href="#collapse79" aria-expanded="true"
							aria-controls="collapse79">
							<h5 class="mt-1 mb-0">
							<span> <!-- Group of material radios - option 1 -->
								<!-- Default unchecked -->
								<div class="custom-control custom-radio">
									  <input type="radio" class="custom-control-input payOption" id="defaultGroupExamplecredit1" name="payment_option" value="OPTDBCRD">
									  <label class="custom-control-label" for="defaultGroupExamplecredit1">Debit Card</label>
								</div>

							</span>							  
							</h5>
						  </div>

						</div>

						<!-- Card body -->
						<div id="collapse79" class="collapse show cardP" role="tabpanel" aria-labelledby="heading79"
						  data-parent="#accordionEx78">
						  <div class="card-body">
							<!--Top Table UI-->							
								
								<div class="m-4">
							    <!--Top Table UI-->
								  <div class="row">
								  	<div class="col-12 my-2">
								     <div class="form-group">
										<label for="cc-number" class="control-label mb-1">Select Card</label>
										 <select name="card_name" class="form-control debit_card_name" id="card_name"> 
										 </select>
									  </div>
									</div>
								</div>

								<div class="row">
								    <div class="col my-2">
								     <div class="form-group">
										<label for="cc-number" class="control-label mb-1">
										Card number</label>
										<span class="input-group-prepend">
									      <span class="input-group-text">
									        <i class="fa fa-credit-card"></i>
									      </span>
									      	<input id="card_number" name="card_number" type="text" class="form-control cc-exp" required placeholder="Card Number" autocomplete="card_number" inputmask="'mask': '9999 9999 9999 9999'"  />
									    </span>
								
										<span class="invalid-feedback">Enter a valid 16 digit card number
									</span>
									  </div>
									</div>
									<div class="col my-2">
											<div class="form-group">
												<label for="cc-exp" class="control-label mb-1">Expiry Month</label>
												<span class="input-group-prepend">
												 <span class="input-group-text">
											        <i class="fa fa-calendar"></i>
											     </span>

												<input id="expiry_month" name="expiry_month" type="text" class="form-control cc-exp" required placeholder="MM" maxlength="2" autocomplete="expiry_month" inputmask="'mask': '99'"/>
												</span>
												<span class="invalid-feedback">Enter the expiration month</span>
											</div>
										</div>
								</div>
									  
									  <div class="row">
										<div class="col my-2">
											<div class="form-group">
												<label for="cc-exp" class="control-label mb-1">Expiry Year</label>
												<span class="input-group-prepend">
												<span class="input-group-text">
											        <i class="fa fa-calendar"></i>
											     </span>
												<input id="expiry_year" name="expiry_year" type="text" class="form-control cc-exp" required placeholder="YYYY" maxlength="4" autocomplete="expiry_year" />
												</span>
												<span class="invalid-feedback">Enter the expiration Year</span>
											</div>
										</div>

										<div class="col my-2">
											<label for="cvv_number" class="control-label mb-1">CVV</label>
											<div class="input-group">
												<input id="cvv_number" name="cvv_number" type="tel" class="form-control cc-exp" placeholder="CVV" required maxlength="3" autocomplete="off">
												<span class="invalid-feedback order-last">
												Enter the 3-digit code on back</span>
												<div class="input-group-append">
												<div class="input-group-text">
												<span class="fa fa-question-circle fa-lg"></span>
												</div>
												</div>
											</div>
										</div>	


									</div>
 
										<div class="col my-2">
										<label for="x_card_code" class="control-label mb-1"></label>
										<button id="payment-button" type="submit" class="btn btn-lg btn-danger btn-block">
											&nbsp;
											<span id="payment-button-amount">Pay $100</span>
											<!-- <span id="payment-button-sending" style="display:none;">Sending…</span> -->
										</button>
										
									   </div>
									 
								
                            </div>

							<!-- Table responsive wrapper -->

						  </div>
						</div>
					  </div>

					  <!-- Accordion card -->
					  <div class="card maincard1">
						<!-- Card header -->
						<div class="card-header" role="tab" id="heading80">
						  <!--Options-->
					  <!-- Heading -->
						  <div data-toggle="collapse" data-parent="#accordionEx78" href="#collapse85" aria-expanded="true"
							aria-controls="collapse85">
						    <h5 class="mt-1 mb-0">
							<span> <!-- Group of material radios - option 1 -->
								<!-- Default unchecked -->
								<div class="custom-control custom-radio">
									  <input type="radio" class="custom-control-input payOption" id="defaultUnchecked2" name="payment_option" value="OPTNBK">
									  <label class="custom-control-label" for="defaultUnchecked2">Net Banking</label>
								</div>
						
							</span>							  
							</h5>
						  </div>
						</div>

						<!-- Card body -->
						<div id="collapse85" class="collapse show cardP" role="tabpanel" aria-labelledby="collapse85"
						  data-parent="#accordionEx78">
						  
						 <div class="card-body">
							<!--Top Table UI-->							
								
								<div class="m-4">
							    <!--Top Table UI-->
						
								  <div class="row">
								  	<div class="col-12 my-2">
								     <div class="form-group">
										<label for="cc-number" class="control-label mb-1">
										Select Card</label>
										 <select name="card_name" class="form-control nb_card_name" id="card_name"> 
										 </select>
									  </div>
									</div>
								</div>


								<div class="row">
								    <div class="col my-2">
								     <div class="form-group">
										<label for="cc-number" class="control-label mb-1">
										Card number</label>
										<span class="input-group-prepend">
									      <span class="input-group-text">
									        <i class="fa fa-credit-card"></i>
									      </span>
									      	<input id="card_number" name="card_number" type="text" class="form-control cc-exp" required placeholder="Card Number" autocomplete="card_number" inputmask="'mask': '9999 9999 9999 9999'"  />
									    </span>
										<span class="invalid-feedback">Enter a valid 16 digit card number
									</span>
									  </div>
									</div>
									<div class="col my-2">
											<div class="form-group">
												<label for="cc-exp" class="control-label mb-1">Expiry Month</label>
													<span class="input-group-prepend">
												 <span class="input-group-text">
											        <i class="fa fa-calendar"></i>
											     </span>

												<input id="expiry_month" name="expiry_month" type="text" class="form-control cc-exp" required placeholder="MM" maxlength="2" autocomplete="expiry_month" inputmask="'mask': '99'"/>
												</span>
												<span class="invalid-feedback">Enter the expiration month</span>
											</div>
										</div>
								</div>
									  
									  <div class="row">
										<div class="col my-2">
											<div class="form-group">
												<label for="cc-exp" class="control-label mb-1">Expiry Year</label>
												<span class="input-group-prepend">
												<span class="input-group-text">
											        <i class="fa fa-calendar"></i>
											     </span>
												<input id="expiry_year" name="expiry_year" type="text" class="form-control cc-exp" required placeholder="YYYY" maxlength="4" autocomplete="expiry_year" />
												</span>
												<span class="invalid-feedback">Enter the expiration Year</span>
											</div>
										</div>

										<div class="col my-2">
											<label for="cvv_number" class="control-label mb-1">CVV</label>
										<div class="input-group">
												<input id="cvv_number" name="cvv_number" type="tel" class="form-control cc-exp" placeholder="CVV" required maxlength="3" autocomplete="off">
												<span class="invalid-feedback order-last">
												Enter the 3-digit code on back</span>
											<div class="input-group-append">
												<div class="input-group-text">
												<span class="fa fa-question-circle fa-lg"></span>
												</div>
											</div>
										</div>
									</div>	


									</div>
 
										<div class="col my-2">
										<label for="x_card_code" class="control-label mb-1"></label>
										<button id="payment-button" type="submit" class="btn btn-lg btn-danger btn-block">
											&nbsp;
											<span id="payment-button-amount">Pay $100</span>
											<!-- <span id="payment-button-sending" style="display:none;">Sending…</span> -->
										</button>
										
									   </div>
									 
								
                            </div>

							<!-- Table responsive wrapper -->

						  </div>

						  <!--card body end-->
						</div>
					  </div>
					  <!-- Accordion card -->

				  <!-- Accordion card -->
				  <div class="card maincard1">
					<!-- Card header -->
					<div class="card-header" role="tab" id="heading">
					  <!--Options-->
		     		  <!-- Heading -->
					  <div data-toggle="collapse" data-parent="#accordionEx78" href="#collapse81" aria-expanded="true"
						aria-controls="collapse81">
					      <h5 class="mt-1 mb-0">
							<span> <!-- Group of material radios - option 1 -->			
								<div class="custom-control custom-radio">
							<input type="radio" class="custom-control-input payOption" id="defaultUnchecked3" name="payment_option" value="OPTEMI">
							<label class="custom-control-label" for="defaultUnchecked3">
							EMI (Easy Installments)</label>
							</div>						
							</span>							  
							</h5>
					  </a>
					</div>

					<!-- Card body -->
					<div id="collapse81" class="collapse show cardP" role="tabpanel" aria-labelledby="heading"
					  data-parent="#accordionEx78">
					  <div class="card-body">
						<!--Top Table UI-->
		                 <div class="bs-example px-4 py-5">
						<!-- <h5>Pay in easy monthly installments from any of the options below.
						   <small>Terms and Conditions</small> 
						</h5> -->
						&nbsp;
							<div class="accordion" id="accordionExample">
								<div class="">

									<div class="" id="headingOne" style="display:none;">
										<h2 class="mb-0">
										<button type="button"  class=" btn-danger " data-toggle="collapse" data-target="#collapseOne">
										
										<i class="fa fa-plus"></i>&nbsp; No Cost EMI <small>Applicable on 2 products in your order</small></button>									
										</h2>
									</div>
							 		

								   <div id="emi_div" style="display: none">
								         <table border="1" width="100%">
								         <tr> 
								         	<td colspan="2"><center>EMI Section</center> </td></tr>
								         <tr> <td> Emi plan id: </td>
								            <td><input readonly="readonly" type="text" id="emi_plan_id"  name="emi_plan_id" value=""/> </td>
								         </tr>
								         <tr>
								          <td> Emi tenure id: </td>
								            <td><input readonly="readonly" type="text" id="emi_tenure_id" name="emi_tenure_id" value=""/>  </td>
								         </tr>
								         <tr>
								         	<td>Pay Through</td>
									         <td>
										         <select name="emi_banks"  id="emi_banks">
										         </select>
									         </td>
								        </tr>
								        <tr>
								        	<td colspan="2">
									         <div id="emi_duration" class="span12">
							                	<span class="span12 content-text emiDetails">
							                		<center>EMI Duration</center></span>
							                    <table id="emi_tbl" border="1" width="100%">
												</table> 
							                </div>
									        </td>
								        </tr>
								        <tr>
								        	 <td id="processing_fee" colspan="2">
								        	</td>
								        </tr>
								</table>
		       				 </div>

								</div>
							</div>
						</div>
					  </div>
					</div>
				  </div>
				   
				  <!-- Accordion card -->
				   <div class="card maincard1">
					<!-- Card header -->
					<div class="card-header" role="tab" id="heading">
					  <!--Options-->
					  <!-- Heading -->
					  <div data-toggle="collapse" data-parent="#accordionEx70" href="#collapse70" aria-expanded="true"
						aria-controls="collapse70">
						<h5 class="mt-1 mb-0">
						<span> <!-- Group of material radios - option 1 -->
							 <div class="custom-control custom-radio">
								  <input type="radio" class="custom-control-input payOption" id="defaultUnchecked6" name="payment_option" value="OPTWLT">
								  <label class="custom-control-label" for="defaultUnchecked6"> Wallet </label>
							 </div>						
						</span>							  
						</h5>
					  </div>
					</div>
					<!-- Card body -->
					<div id="collapse70" class="collapse show cardP" role="tabpanel" aria-labelledby="heading"
					  data-parent="#accordionEx70">
					  <div class="card-body">
						<!--Top Table UI-->
						<div class="m-4">
							    <!--Top Table UI-->
								  <div class="row">
								  	<div class="col-12 my-2">
								     <div class="form-group">
										<label for="cc-number" class="control-label mb-1">
										Select Card</label>
										 <select name="card_name" class="form-control wlt_card_name" id="card_name"> 
										 </select>
									  </div>
									</div>
								</div>
								<div class="row">
								    <div class="col my-2">
								     <div class="form-group">
										<label for="cc-number" class="control-label mb-1">
										Card number</label>
									<input id="card_number" name="card_number" type="text" class="form-control cc-exp" required placeholder="Card Number" autocomplete="card_number" pattern="[0-9]{16}"/>
										<span class="invalid-feedback">Enter a valid 16 digit card number
									</span>
									  </div>
									</div>
									<div class="col my-2">
											<div class="form-group">
												<label for="cc-exp" class="control-label mb-1">Expiry Month</label>
												<input id="expiry_month" name="expiry_month" type="text" class="form-control cc-exp" required placeholder="MM" maxlength="2" autocomplete="expiry_month">
												<span class="invalid-feedback">Enter the expiration month</span>
											</div>
										</div>
								</div>
									  
									  <div class="row">
										<div class="col my-2">
											<div class="form-group">
												<label for="cc-exp" class="control-label mb-1">Expiry Year</label>
												<input id="expiry_year" name="expiry_year" type="text" class="form-control expiry_year cc-exp" required placeholder="YYYY" autocomplete="expiry_year" maxlength="4">
												<span class="invalid-feedback">Enter the expiration Year</span>
											</div>
										</div>

										<div class="col my-2">
											<label for="cvv_number" class="control-label mb-1">CVV</label>
											<div class="input-group">
												<input id="cvv_number" name="cvv_number" type="tel" class="form-control cc-exp" placeholder="CVV" required maxlength="3" autocomplete="off">
												<span class="invalid-feedback order-last">
												Enter the 3-digit code on back</span>
												<div class="input-group-append">
													<div class="input-group-text">
													<span class="fa fa-question-circle fa-lg"></span>
													</div>
												</div>
										</div>
										</div>	


									</div>
 
   
										<div class="col my-2">
										<label for="x_card_code" class="control-label mb-1"></label>
										<button id="payment-button" type="submit" class="btn btn-lg btn-danger btn-block">
											&nbsp;
											<span id="payment-button-amount">Pay $100</span>
											<span id="payment-button-sending" style="display:none;">Sending…</span>
										</button>
										
									   </div>
									 
								
									
								
                            </div>

							<!-- Table responsive wrapper -->


					  </div>
					</div>
				  </div>
				  
				  
				  <!-- Accordion card -->
				   <div class="card maincard1" style="">
					<!-- Card header -->
					<div class="card-header" role="tab" id="heading">
					  <!--Options-->
		     		  <!-- Heading -->
					  <div data-toggle="collapse" data-parent="#accordionEx79" href="#collapse82" aria-expanded="true"
						aria-controls="collapse82">
					      <h5 class="mt-1 mb-0">
							<span> <!-- Group of material radios - option 1 -->
								<!-- Default unchecked -->
							<div class="custom-control custom-radio">
								  <input type="radio" class="custom-control-input payOption" id="defaultUnchecked5" name="payment_option">
								  <label class="custom-control-label" for="defaultUnchecked5"> Other </label>
							 </div>	
						
							</span>							  
							</h5>
					  </div>
					</div>

					<!-- Card body -->
					<div id="collapse82" class="collapse " role="tabpanel" aria-labelledby="heading"
					  data-parent="#accordionEx79">
					  <div class="card-body">
						<!--Top Table UI-->
		                   	<div class="m-4">

		                   		   <h5 class="mt-1 mb-0">
							   <!-- Group of material radios - option 1 -->
								<!-- Default unchecked -->
							<div class="custom-control custom-radio">
								  <input type="radio" class="custom-control-input payOption" id="defaultUnchecked" name="payment_option" onclick="razorpaySubmit(this);">
								  <label class="custom-control-label" for="defaultUnchecked"> Razorpay </label>
							 </div>	
						
							 					  
							</h5>

		                   	</div>
					  </div>
					</div>
				  </div>
				  	<!--end content--->
				  </form>


				  <!---razor payment gateway--->

				   <?php 

				   if ($pending_order == 'Accepted') { ?>
                <form name="razorpay-form" id="razorpay-form" action="<?php echo $return_url; ?>" method="POST">
                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" />
                    <input type="hidden" name="merchant_order_id" id="merchant_order_id" value="<?php echo $merchant_order_id; ?>"/>
                    <input type="hidden" name="merchant_trans_id" id="merchant_trans_id" value="<?php echo $txnid; ?>"/>
                    <input type="hidden" name="merchant_product_info_id" id="merchant_product_info_id" value="<?php echo $productinfo; ?>"/>
                    <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $surl; ?>"/>
                    <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $furl; ?>"/>
                    <input type="hidden" name="card_holder_name_id" id="card_holder_name_id" value="<?php echo $card_holder_name; ?>"/>
                    <input type="hidden" name="merchant_total" id="merchant_total" value="<?php echo $total; ?>"/>
                    <input type="hidden" name="order_id" id="order_id" value="<?php echo $merchant_order_id; ?>"/>

                </form>
            <?php } ?>
				</div>
				<!--/.Accordion wrapper-->
				<!-- Comments -->
				</div>
		
				</div>
			</div>
            <!--Grid column-->
			
 

            <!--Grid column-->
            <div class="col-md-4 mb-4 ">
                <!--Card-->
                <div class="card mb-4 maincard">
                    <!-- Card header -->
                    <div class="card-header">Amount</div>
                    <!--Card content-->
                    <div class="card-body d-flex justify-content-between">
                        <p class="mb-0 pt-2">
                            <!-- <i class="fas fa-reply purple-text mr-2"></i>Answered </p> -->
                           <!-- <strong>&#x20b9;</strong> -->
                           
                           
                       </p>
                    </div>
                </div>
                <!--/.Card-->
                <!--Card-->
                <div class="card mb-4 maincard">
                    <!-- Card header -->
                    <div class="card-header">Billing Information</div>
                    <!--Card content-->
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li>
                                <strong>Billing Name:</strong>
                                <span>Pro</span>
                                
                            </li>
                            <li>
                                <strong>Billing Address:</strong>
                                <span>No</span>
                                
                            </li>
                            <li>
                                <strong>Billing City:</strong>
                                <span>General Bootstrap questions</span>
                               
                            </li>
                            <li>
                                <strong>Billing State:</strong>
                                <span>-</span>
                                
                            </li>
                            <li>
                                <strong>Billing Zip:</strong>
                                <span>-</span>
                                
                            </li>
                            <li>
                                <strong>Country:</strong>
                                <span>India</span>
                              
                            </li>
                           
                        </ul>
                    </div>
                </div>


                <div class="card mb-4 maincard">
                    <!-- Card header -->
                    <div class="card-header">Shipping Information</div>
                    <!--Card content-->
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li>
                                <strong>Shipping Name:</strong>
                                <span>Pro</span>
                               
                            </li>
                            <li>
                                <strong>Shipping Address:</strong>
                                <span>No</span>
                               
                            </li>
                            <li>
                                <strong>Shipping City:</strong>
                                <span>General Bootstrap questions</span>
                           
                            </li>
                            <li>
                                <strong>Shipping State:</strong>
                                <span>-</span>
                               
                            </li>
                            <li>
                                <strong>Shipping Zip:</strong>
                                <span>-</span>
                        
                            </li>
                            <li>
                                <strong>Shipping Telephone:</strong>
                                <span>-</span>
                              
                            </li>
                           
                        </ul>
                    </div>
                </div>

                <!--/.Card-->
 
            </div>
            <!--Grid column-->
           
        </div>
        <!--Grid row-->
    </div>
</main>
<!-- <?php $this->load->view("front/common/footer"); ?> -->
<script src="<?= base_url('assets/json/json.js')?>"></script>
<script src="<?= base_url('assets/front/js/jquery-3.2.1.min.js')?>"></script>
<script src="<?= base_url('assets/front/js/jquery.creditCardValidator.js')?>"></script>
<script src="<?= base_url('assets/front/js/jquery.inputmask.bundle.js')?>"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="<?= base_url('assets/front/js/payment.js')?>"></script> 

<script type="text/javascript">
									var razorpay_options = {
                                        key: "<?php echo $key_id; ?>",
                                        amount: "<?php echo $total; ?>",
                                        name: "<?php echo $name; ?>",
                                        description: "Order # <?php echo $merchant_order_id; ?>",
                                        netbanking: true,
                                        currency: "<?php echo $currency_code; ?>",
                                        //order_id: "<?php echo $merchant_order_id; ?>",
                                        prefill: {
                                            name: "<?php echo $card_holder_name; ?>",
                                            email: "<?php echo $email; ?>",
                                            contact: "<?php echo $phone; ?>",
                                        },
                                        notes: {
                                            soolegal_order_id: "<?php echo $merchant_order_id; ?>",
                                        },
                                        handler: function (transaction) {

                                            document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
                                            document.getElementById('razorpay-form').submit();
                                            $('#loading').show();
                                        },
                                        "modal": {
                                            "ondismiss": function () {
                                                location.reload()
                                            }
                                        }
                                    };
                                    var razorpay_submit_btn, razorpay_instance;

                                            function razorpaySubmit(el) {
                                        /**
                                         * Before calling razor pay we check 
                                         * wheather the user has been banned by admin or not 
                                         * iff yes(true) then don't let them shopping
                                         * logout of the system by redirecting
                                         * @param pass nothing we will check it from session
                                         */
                                        $(document).ready(function () {
                                            $.post('<?php echo base_url('userorder/checkBeforePay') ?>', {name: "John", time: "2pm"})
                                                    .done(function (isBanned) {
                                                        if(isBanned == 0){
                                                            alert('Your account has been banned. Please contact support!');
                                                            window.location.href = "<?php echo base_url('login'); ?>";
                                                            exit();
                                                        } 
                                                        
                                                    });
                                        });
                                        if (typeof Razorpay == 'undefined') {
                                            setTimeout(razorpaySubmit, 200);
                                            if (!razorpay_submit_btn && el) {
                                                razorpay_submit_btn = el;
                                                el.disabled = true;
                                                el.value = 'Please wait...';
                                            }
                                        } else {
                                            if (!razorpay_instance) {
                                                razorpay_instance = new Razorpay(razorpay_options);
                                                if (razorpay_submit_btn) {
                                                    razorpay_submit_btn.disabled = false;
                                                    razorpay_submit_btn.value = "Pay Now";
                                                }
                                            }
                                            razorpay_instance.open();
                                        }
                                    }


</script>
</body>
</html>
