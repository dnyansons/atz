<?php $this->load->view("front/common/header"); ?>
<style>
.ocms-fusion-atzcart-pc-ggs-buy .inner .list .item .con .info
{
	height:auto !important;
}

.ocms-fusion-atzcart-pc-ggs-buy .inner .list .item
{
	height:600px !important;
}
.ocms-fusion-atzcart-pc-ggs-buy .inner .list .item .con
{
	height:600px !important;
}
.form-control
{
	border:1px solid #ccc !important;
	
}
label{
	margin-top:8px;
	margin-right:10px;
}
</style>
<div class="ocms-container" dir="ltr">
    <div  class="ocms-fusion-atzcart-pc-common-layout-1-0-3">
        <div class="ocms-fusion-atzcart-pc-common-layout b2b-ocms-fusion-layout full" data-reactroot="" data-reactid="1"
            data-react-checksum="-1069206832">
            <div name="main" class="croco slot">
                <div   class="ocms-fusion-atzcart-pc-ggs-banner-1-0-3 ctrdot-item ctrdot-item-ocms"   >
                    <div class="ocms-fusion-atzcart-pc-ggs-banner b2b-ocms-fusion-comp" >
                        <link rel="stylesheet" href="//at.alicdn.com/t/font_1026203_7w69v5pkrky.css" data-reactid="2">
                        <div class="banner"
                            style="height:352px;background-image:"
                            data-reactid="3">
                            <div class="inner" data-reactid="4">
                                <h1 data-reactid="5">atzcart.com Gold Supplier Membership</h1>
                                <div class="text" data-reactid="6">A premium membership that helps maximize your
                                    company's product exposure to buyers globally.</div>
                                <div class="list" data-reactid="7"
                                    data-spm-anchor-id="a272f.12530124.jr7f0qr6.i0.270b16d03qHK6G">
                                    <div class="item" data-reactid="8">
                                        <div class="icon" data-reactid="9"><i class="iconfont icon-zhiliang-xianxing"
                                                data-reactid="10"></i></div>
                                        <div class="info" data-reactid="11">
                                            <div class="tit" data-reactid="12">GAIN CREDIBILITY</div>
                                            <div class="txt" data-reactid="13">Get authenticated by atzcart.com &amp;
                                                build instant credibility with buyers</div>
                                        </div>
                                    </div>
                                    <div class="item" data-reactid="14">
                                        <div class="icon" data-reactid="15"><i
                                                class="iconfont icon-hezuoguanxi-xianxing" data-reactid="16"></i></div>
                                        <div class="info" data-reactid="17">
                                            <div class="tit" data-reactid="18">BUILD RELATIONSHIPS</div>
                                            <div class="txt" data-reactid="19">Respond to buyer inquiries &amp; build
                                                relationships</div>
                                        </div>
                                    </div>
                                    <div class="item" data-reactid="20">
                                        <div class="icon" data-reactid="21"><i class="iconfont icon-zhexiantu-xianxing"
                                                data-reactid="22"></i></div>
                                        <div class="info" data-reactid="23">
                                            <div class="tit" data-reactid="24">GROW BUSINESS</div>
                                            <div class="txt" data-reactid="25">Rank higher in search results &amp; be
                                                more discoverable</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ocms-fusion-atzcart-pc-ggs-buy-1-2-0 ctrdot-item ctrdot-item-ocms" >
                    <div class="ocms-fusion-atzcart-pc-ggs-buy b2b-ocms-fusion-comp" id="card" data-reactroot=""
                        data-reactid="1">
                        <link rel="stylesheet" href="//at.alicdn.com/t/font_1026203_4ed1dnvjjcx.css" data-reactid="2">
                        <div class="buy" data-reactid="3">
                            <div class="inner" data-reactid="4">
                               
                             
                                <div class="list" data-reactid="10">
								<?php foreach($packages as $result){
									
									if($result['pkg']['sub_id']!=1){
									?>
                                    <div class="item">
                                        <div class="con">
                                            <div class="tag"><i></i><span></span></div><img
                                                src="<?php echo base_url();?>assets/pkg.png"
                                                class="img">
                                            <div class="type"><?php echo $result['pkg']['pkg_name']; ?></div>
                                            <div class="for"><?php echo $result['pkg']['pkg_sub_title']; ?></div>
                                            <div class="info">
                                                <div class="itm hh"><i class="iconfont icon-zhengquewancheng"></i>
                                                    <!-- react-text: 23 -->
                                                    <!-- /react-text --><span> Product Desciption</span>
                                                    <div class="hover">
                                                        
                                                        <div class="tt">
                                                            <p><?php echo $result['pkg']['pkg_description']; ?> </p>
                                                        </div>
                                                    </div>
                                                </div>
												<div class="itm"><i class="iconfont icon-zhengquewancheng"></i>
                                                    <!-- react-text: 34 -->
                                                    <!-- /react-text --><span>Product showcases : <?php echo $result['pkg']['Product showcases'];?></span>
                                                    <!-- react-text: 36 -->
                                                    <!-- /react-text -->
                                                </div>
                                                <div class="itm"><i class="iconfont icon-zhengquewancheng"></i>
                                                    <!-- react-text: 34 -->
                                                    <!-- /react-text --><span>Product Ranking : <?php echo $result['pkg']['product_ranking'];?></span>
                                                    <!-- react-text: 36 -->
                                                    <!-- /react-text -->
                                                </div>
                                                <div class="itm"><i class="iconfont icon-zhengquewancheng"></i>
                                                    <!-- react-text: 39 -->
                                                    <!-- /react-text --><span>Product Posting : <?php echo $result['pkg']['product_posting'];?></span>
                                                    <!-- react-text: 41 -->
                                                    <!-- /react-text -->
                                                </div>
                                                <div class="itm"><i class="iconfont icon-zhengquewancheng"></i>
                                                    <!-- react-text: 39 -->
                                                    <!-- /react-text --><span>Verified Icon : <?php echo $result['pkg']['verified_icon'];?></span>
                                                    <!-- react-text: 41 -->
                                                    <!-- /react-text -->
                                                </div>
												<div class="itm"><i class="iconfont icon-zhengquewancheng"></i>
                                                    <!-- react-text: 39 -->
                                                    <!-- /react-text --><span>Customized Website : <?php echo $result['pkg']['customized_website'];?></span>
                                                    <!-- react-text: 41 -->
                                                    <!-- /react-text -->
                                                </div>
                                            </div><br><br>
											
                                            <div class="acp"><strong><i><?php echo $currency; ?>. </i><!-- react-text: 50 -->
                                                    <!-- /react-text --><b><?php echo $result['price']; ?></b><i>*</i></strong>
                                                <!-- react-text: 53 -->
                                                <!-- /react-text --><span>
                                                    <!-- react-text: 55 -->/
                                                    <!-- /react-text -->
                                                    <!-- react-text: 56 --><?php echo $result['pkg']['duration']; ?>
                                                    <!-- /react-text --></span></div>
                                            <div class="pri">
											
                                                <!-- react-text: 58 -->billed annually (
                                                <!-- /react-text -->
                                                <!-- react-text: 59 --><?php echo $currency; ?>.
                                                <!-- /react-text -->
                                                <!-- react-text: 60 --><?php if($result['pkg']['duration'] == "Month"){ echo round($result['price']*12,2); }else{
													echo round($result['price']/12,2);
												}?>
                                                <!-- /react-text -->
                                                <!-- react-text: 61 -->)
                                                <!-- /react-text -->
                                            </div>
											
											<?php $sub_id=$result['pkg']['sub_id']; ?>
											<a onclick="get_package(<?php echo $sub_id; ?>)" class="choose" data-toggle="modal" data-target="#myModal">
                                                <!-- react-text: 63 -->CHOOSE <?php echo strtoupper($result['pkg']['pkg_name']); ?>
                                                <!-- /react-text -->
                                                <!-- react-text: 64 -->
                                                <!-- /react-text --><i class="iconfont icon-zhixiangyou"></i></a>
                                        </div>
                                    </div>
									<?php } } ?>
                                    
									
                                <div class="tip" data-reactid="11">Can’t decide yet? <a
                                        href=""
                                        target="_blank"> Chat with sales</a> to find the right plan for your business.
										
	
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ocms-fusion-atzcart-pc-ggs-features-1-0-2 ctrdot-item ctrdot-item-ocms">
                    <div class="ocms-fusion-atzcart-pc-ggs-features b2b-ocms-fusion-comp" data-reactroot=""
                        data-reactid="1" data-react-checksum="1157009536">
                        <div class="features" data-reactid="2">
                            <div class="inner" data-reactid="3"
                                data-spm-anchor-id="a272f.12530124.jr7f1qh6.i0.270b16d03qHK6G">
                                <h3 data-reactid="4">Every membership plan gives you access to a suite of
                                    business-boosting features</h3>
                                <div class="list" data-reactid="5">
                                    <div class="item" data-reactid="6">
                                        <div class="icon" data-reactid="7"><img
                                                src="https://img.alicdn.com/tfs/TB1OkOuDb2pK1RjSZFsXXaNlXXa-50-50.png"
                                                data-reactid="8"></div>
                                        <div class="info" data-reactid="9">
                                            <div class="num" data-reactid="10">1,000,000+</div>
                                            <div class="txt" data-reactid="11">Global Buyers</div>
                                        </div>
                                    </div>
                                    <div class="item" data-reactid="12">
                                        <div class="icon" data-reactid="13"><img
                                                src="https://img.alicdn.com/tfs/TB1rCmCDgHqK1RjSZFEXXcGMXXa-50-50.png"
                                                data-reactid="14"></div>
                                        <div class="info" data-reactid="15">
                                            <div class="num" data-reactid="16">190+</div>
                                            <div class="txt" data-reactid="17">Countries / Regions</div>
                                        </div>
                                    </div>
                                    <div class="item" data-reactid="18">
                                        <div class="icon" data-reactid="19"><img
                                                src="https://img.alicdn.com/tfs/TB14KyVDhjaK1RjSZKzXXXVwXXa-50-50.png"
                                                data-reactid="20"></div>
                                        <div class="info" data-reactid="21">
                                            <div class="num" data-reactid="22">18</div>
                                            <div class="txt" data-reactid="23">Real-Time Chat Translation Languages
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item" data-reactid="24">
                                        <div class="icon" data-reactid="25"><img
                                                src="https://img.alicdn.com/tfs/TB1LrmpDgDqK1RjSZSyXXaxEVXa-50-56.png"
                                                data-reactid="26"></div>
                                        <div class="info" data-reactid="27">
                                            <div class="num" data-reactid="28">500,000+</div>
                                            <div class="txt" data-reactid="29">Active Inquiries</div>
                                        </div>
                                    </div>
                                    <div class="item" data-reactid="30">
                                        <div class="icon" data-reactid="31"><img
                                                src="https://img.alicdn.com/tfs/TB1FsmuDhTpK1RjSZR0XXbEwXXa-50-53.png"
                                                data-reactid="32"></div>
                                        <div class="info" data-reactid="33">
                                            <div class="num" data-reactid="34">5,900+</div>
                                            <div class="txt" data-reactid="35">Product Categories</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ocms-fusion-atzcart-pc-ggs-faq-1-0-6 ctrdot-item ctrdot-item-ocms">
                    <div class="ocms-fusion-atzcart-pc-ggs-faq b2b-ocms-fusion-comp" data-reactroot="" data-reactid="1"
                        data-react-checksum="2042126862">
                        <div class="faq" data-reactid="2">
                            <div class="inner" data-reactid="3">
                                <h3 data-reactid="4">Your Questions Answered</h3>
                                <div class="list" data-reactid="5">
                                    <div class="listItem" data-reactid="6">
                                        <div class="item" data-reactid="7">
                                            <div class="question" data-reactid="8">What’s the difference between the
                                                three packages?</div>
                                            <div class="show" data-reactid="9">
                                                <div class="question" data-reactid="10">What’s the difference between
                                                    the three packages?</div>
                                                <div class="answer" data-reactid="11">The main difference between the
                                                    packages is the number of showcase. When you select a product to
                                                    “showcase”, that product will get up to 100 times more exposure than
                                                    a non-showcased products.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="listItem" data-reactid="12">
                                        <div class="item" data-reactid="13">
                                            <div class="question" data-reactid="14">How do I upgrade from a free account
                                                to a Gold membership?</div>
                                            <div class="show" data-reactid="15">
                                                <div class="question" data-reactid="16">How do I upgrade from a free
                                                    account to a Gold membership?</div>
                                                <div class="answer" data-reactid="17">There are 3 steps required to
                                                    become a Gold member on atzcart.com <br> - Pay the yearly membership
                                                    fee. <br> - Pass the authentication check. This usually takes 1-2
                                                    weeks. <br> - Activate your Gold supplier account. <br></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="listItem" data-reactid="18">
                                        <div class="item" data-reactid="19">
                                            <div class="question" data-reactid="20">What payment methods are accepted to
                                                pay the membership fee?</div>
                                            <div class="show" data-reactid="21">
                                                <div class="question" data-reactid="22">What payment methods are
                                                    accepted to pay the membership fee?</div>
                                                <div class="answer" data-reactid="23">atzcart.com accepts Visa and
                                                    MasterCard, but wire transfer (T/T) can also be used to complete
                                                    payment.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tip" data-reactid="24">Have more questions? <a
                                        href="https://gcx.atzcart.com/icbu/anna/portal.htm?pageId=370185&amp;_param_digest_=df4111722ccba2d889e7356aaff879fb"
                                        target="_blank">Chat with sales</a> to know more.</div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
</div>
									<!-- Button to Open the Modal -->


<!-- The Modal -->
<div class="modal fade" id="myModal">
   <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Supplier Membership</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
	<form action="<?php echo base_url(); ?>supplier_membership/proceed_package" method="post">
      <!-- Modal body -->
      <div class="modal-body" >
      <div style="text-align:center">
		
		   <div class="form-group input-group">
			  <label>Selected Package</label>
			  <input type="hidden" name="spkg_id" id="spkg_id" value="0" >
			  <input type="text" value="" id="spkg_name" class="form-control" readonly="" >
		   </div>
		   <div class="form-group input-group">
		        <label>Select Duration&nbsp;&nbsp;&nbsp;&nbsp;</label>
				<select class="form-control" name="pkg_duration" onchange="cal_pkg_price(this.value);">
					<label>Select Duration</label>
					<option value="1" selected>1 Month</option>
					<option value="3">3 Month</option>
					<option value="6">6 Month</option>
					<option value="12">12 Month</option>
					<option value="24">24 Month</option>
					<option value="48">48 Month</option>
				</select>
		   </div>
		    <div class="form-group input-group">
			  <label>Calculated Price &nbsp;</label>
			  <input type="number" class="form-control" id="cal_price" value="0" readonly="" >
		   </div>
		   
		
      </div>
      </div>
	
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Proceed</button>
      </div>
	</form>
    </div>
  </div>
</div>
<script>
 function get_package(pkg)
      {	
		 $.ajax({
              type:'POST',
              url :'<?php echo base_url(); ?>supplier_membership/get_package',
              data: {'pkg':pkg},
              success:function(data){
				if(data!='error')
				{
					var dat=data.split('||');
					
					$('#spkg_id').val(dat[0]);
					$('#spkg_name').val(dat[1]);
					$('#cal_price').val(dat[2]);
				}
      
      
              },
              error:function(){
                      alert('Somthing Wrong !'); 
              }
          });
      }
	  
	  
	 function cal_pkg_price(duration)
	 {
		  var pkg_id=$('#spkg_id').val();
		 
		  $.ajax({
              type:'POST',
              url :'<?php echo base_url(); ?>supplier_membership/calculate_pkg_price',
              data: {'duration':duration,'pkg_id':pkg_id},
              success:function(data){
				  
				if(data!='error')
				{
					var price=Number(data);
					$('#cal_price').val(price);
				}
      
      
              },
              error:function(){
                      alert('Somthing Wrong !'); 
              }
          });
	 }		 
	  
   </script>
<?php $this->load->view("front/common/footer"); ?>