
<?php $this->load->view('front/common/header'); ?>
<style type="text/css">     
	.common-search{padding : 100px;width: 100%;}
	.active{color:red !important;}
	a{cursor:pointer;}
</style>
  <div class="help-center">
    <div class="grid common-search">
        <div class="help-title-tip">How Can We Help?</div>
    </div>
    <div class="mod-main width-range">
        <div class="breadcrumb">
            <div class="en-us" >
                <div class="ui-breadcrumb">
                    <a href="">Help Center</a>
                    <span class="divider">&gt;</span>
                    <span class="active">ATZCart.com</span>
                </div>
            </div>
        </div>
        <div class="main-content util-clearfix">
        
            <!-- col-left start--->
            <div class="col-left">
                <div class="side-menu">
                    <h3 class="menu-title">Help Sections</h3>
                    <ul class="level-1" id = "show_parenttitles">
                        
                    </ul>
                </div>               
            </div>
        
            <div class="col-right">
                <div class="col-right-content" id = "show_subtitles">
             
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('front/common/footer'); ?>
<script>
$(document).ready(function(){
	
	 $.ajax({
        url : '<?php echo base_url(); ?>customer_service/ajax_get_titles',
        dataType: 'json',
        type: 'POST',
        success: function(data){
            if(data)
            {
				var parenttitle = '';
                var subtitles = '<ul class="hc-list list list-page">';
				var count = 0;
				var active = '';
				 $.each(data.parent_title, function(idx, obj){
					count++;
					if(count == 1)
					{
						active = "active";
					}else{
						active = "";
					}
                    parenttitle += '<li><i class="hc-icon icon-down"></i><a class="level-1-title level-title '+active+'" onclick = "getSubtitles('+obj.id+')">'+capitalizeFirstLetter(obj.title)+'</a></li>';
                });
				
                $.each(data.subTitles, function(idx, obj){
                    subtitles += '<li><div class="list-content"><a onclick = "get_description('+obj.id+')">'+capitalizeFirstLetter(obj.title)+'</a></div></li>';
                });
				subtitles += '</ul>';
                $('#show_parenttitles').html(parenttitle);
                $('#show_subtitles').html(subtitles);
            }
        },
        
    });
});


function getSubtitles(id)
{
	localStorage.setItem("id",id);
    $.ajax({
        url : '<?php echo base_url(); ?>customer_service/ajxgetSubtitlesOfSeller/'+id,
        dataType: 'json',
        type: 'POST',
        success: function(data){
            if(data)
            {
                var subtitles = '<ul class="hc-list list list-page">';
                $.each(data, function(idx, obj){
                    subtitles += '<li><div class="list-content"><a onclick = "get_description('+obj.id+')" >'+capitalizeFirstLetter(obj.title)+'</a></div></li>';
                });
                subtitles += '</ul>';
                $('#show_subtitles').html(subtitles);
            }
        },
        
    });
}

function get_description(id)
{
	
	$.ajax({
        url : '<?php echo base_url(); ?>help-center-seller-description/'+id,
        dataType: 'json',
        type: 'POST',
        success: function(data){
            if(data)
            {
                var description = '<div class="detail" data-role="detail"><a class="back-to-list" onclick="getSubtitles('+localStorage.getItem("id")+')" >&lt; Back to list</a><h4 class="prompt">'+data.description.title+'</h4><div>'+data.description.description+'</div></div>';
                
                
                $('.col-right-content').html(description);
            }
        },
        
    });
}

$(document).ready(function(){
	$(document).on("click",".level-1 a",function(){
		$('.active').removeClass('active');
		$(this).addClass('active');
	});
});

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

</script>