<!--Footer Part-->
   <!-- <div
        style="border-width: 1px 0px 0px; border-style: solid; border-color: rgb(218, 218, 218) black black; border-image: initial; position: fixed; box-sizing: border-box; display: flex; -webkit-box-orient: horizontal; flex-direction: row; align-content: flex-start; flex-shrink: 0; bottom: -29.0133px; width: 320px; height: 81.92px; background-color: rgb(255, 255, 255); box-shadow: rgb(200, 200, 200) 0px 0px 3px 0px;">
        <div
            style="border: 0px solid black; position: relative; box-sizing: border-box; display: flex; -webkit-box-orient: vertical; flex-direction: column; align-content: flex-start; flex-shrink: 0; cursor: pointer;">
            <a href="<?php// echo base_url(); ?>m/Supplier/supplier_enquiry/<?php //echo $this->session->userdata('seller_id'); ?>"><span
                style="white-space: pre-wrap; border: 0px solid black; position: relative; box-sizing: border-box; display: block; -webkit-box-orient: vertical; flex-direction: column; align-content: flex-start; flex-shrink: 0; font-size: 11.9467px; line-height: 30.72px; width: 140.8px; margin-top: 11.0933px; margin-right: 11.0933px; text-align: center; border-radius: 3.41333px; text-overflow: ellipsis; overflow: hidden; margin-left: 13.6533px; background-image: linear-gradient(to right bottom, rgb(255, 240, 230), rgb(255, 227, 209)); color: rgb(255, 106, 0); box-shadow: rgb(255, 205, 170) 0px 1px 2px 0px;">SEND INQUIRY</span></a></div>
        <div
            style="border: 0px solid black; position: relative; box-sizing: border-box; display: flex; -webkit-box-orient: vertical; flex-direction: column; align-content: flex-start; flex-shrink: 0; cursor: pointer;">
            <span
                style="white-space: pre-wrap; border: 0px solid black; position: relative; box-sizing: border-box; display: block; -webkit-box-orient: vertical; flex-direction: column; align-content: flex-start; flex-shrink: 0; font-size: 11.9467px; line-height: 30.72px; width: 140.8px; margin-top: 11.0933px; margin-right: 13.6533px; text-align: center; border-radius: 3.41333px; text-overflow: ellipsis; overflow: hidden; background-image: linear-gradient(to right bottom, rgb(254, 142, 67), rgb(255, 106, 0)); box-shadow: rgb(255, 170, 108) 0px 1px 2px 0px; color: rgb(255, 255, 255);">CHAT NOW</span></div>
    </div>
	<!-- End Footer Part-->
	

	</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.2.1.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/popper.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/bootstrap.min.js"></script>
 
<script>
jQuery(function ($) {
	$("#navi a").click(function(e) {
		var link = $(this);
		var item = link.parent("li");            
		 if (item.hasClass("active")) {
				item.removeClass("active").children("a").removeClass("active");
			} else {
				item.addClass("active").children("a").addClass("active");
			}           
	})
	.each(function() {
		var link = $(this);
		if (link.get(0).href === location.href) {
			link.addClass("active").parents("li").addClass("active");
		}
	});
		
});		
</script>
</body>
</html>