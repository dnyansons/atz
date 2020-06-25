<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.2.1.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/popper.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery.nivo.slider.pack.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/plugins.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/main.js"></script> 
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery.mmenu.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/swiper.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/mobile/mobile-browse.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/jquery.validate.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mobile/js/custome_validation.js"></script>
<script>
    document.onreadystatechange = function () {
        var state = document.readyState
        if (state == 'interactive') {
            document.getElementById('contents').style.visibility = "hidden";
        } else if (state == 'complete') {
            setTimeout(function () {
                document.getElementById('interactive');
                document.getElementById('load').style.visibility = "hidden";
                document.getElementById('contents').style.visibility = "visible";
            }, 1000);
        }
    }

    //swiper
    var swiper = new Swiper('.swiper-container', {
        pagination: {
            el: '.swiper-pagination',
        },
    });

    // slider multiple option
    $(function () {
        // alert("hello");
        $('nav#menunew').mmenu();
    });

</script>
<script type="text/javascript">
    $("#searchText").on("keyup", function () {
        $('#searchText').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php base_url() ?>m/search",
                    data: {term: request.term},
                    dataType: "json",
                    success: function (data) {
                        $("#search_histroy").html("");
                        var term = encodeURIComponent(request.term);
                        $.each(data,function(key,value){
                            if(value.type == "category"){
                                $("#search_histroy").append('<a href="<?php echo base_url(); ?>search/results/category/' + value.id + '/false/'+value.name+'" class="tag"> <i class="ionicons ion-ios-search-strong"></i> ' + value.name + '<br /> <span class="smte"><small>in '+value.parent_name+'</small><span><i class="arr ionicons ion-arrow-up-c"></i> </a>');   
                                } else {
                                $("#search_histroy").append('<a href="<?php echo base_url(); ?>search/results/product/' + value.parent_id + '/true/'+value.name+'" class="tag"> <i class="ionicons ion-ios-search-strong"></i> ' + value.name + '<br /> <span class="smte"><small>in '+value.parent_name+'</small></span><i class="arr ionicons ion-arrow-up-c"></i> </a>');
                            }  
                        });
                    }
                });
            }
        });
    });
</script>
</body>
</html>
