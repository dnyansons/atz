
<script>
$(document).on("click",".add_favorite",function () {
    var product_id = $(this).data("product-id");
    $.ajax({
        url: "<?php echo base_url(); ?>home_product/add_to_favorite",
        method: "POST",
        data: {"product_id": product_id},
        dataType: "JSON",
        success: function (data)
        {
            console.log(data);
            if (data.status == 0)
            {
                window.location.href = "<?php echo site_url(); ?>login";

            } else if (data.status == 1) {

                alert(data.message);

            } else if (data.status == 2) {

                var fav = $('#fav_count').html();
                location.reload();
                $('#fav_count').html(parseInt(fav) + 1);
                // addedfavorite();
            }
        }

    });
});

function addedfavorite()
{
    $.ajax({
        url: '<?php echo base_url(); ?>getaddefavoriteProducts',
        method: 'POST',
        dataType: 'json',
        success: function (data) {
            // console.log(data);
            if (data.result == 0) {
                window.location.href = "<?php echo base_url(); ?>login";
            }else{
                var favprod = '';
                $("#fav_count").html(data.length);

                for ($k = 0; $k < data.length; $k++) {

                    favprod +='<div class="user-pic col-sm-3 p-0"><a href="<?php echo base_url(); ?>favorite"><img src="'+data[$k].media_url+'" width="35" class="img-fluid"></a>' +
                        '</div><div class="user-info col-sm-9 pl-1 pr-0"><div class="user-name"><a href="<?php echo base_url(); ?>favorite" >\'+data[$k].name+\'\n' +
                        '</a></div><div class="user-role"><span class="user-status"><span><i class="fa fa-inr fa-3x"></i>'+data[$k].max_final_price+'</span>' +
                        '</span></div></div>';
                }
                $("#fav_product").html(favprod);
                location.reload();
            }
        },
    });
}
</script>
