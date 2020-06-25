<style>
    * {
        box-sizing: border-box;
    }

    h3 {
        font-size: 18px;
        margin: 10px 0;
    }
    p{margin-bottom: 10px;}
    /* The actual timeline (the vertical ruler) */
    .timeline {
        position: relative;
        max-width: 800px;
        margin: 0 auto;
    }

    /* The actual timeline (the vertical ruler) */
    .timeline::after {
        content: '';
        position: absolute;
        width: 6px;
        background-color: #b6b8bb;
        top: 100px;
        bottom: 0;
        left: 50%;
        margin-left: -3px;
    }

    /* container_new around content */
    .container_new {
        padding: 1px 40px;
        position: relative;
        background-color: inherit;
        width: 50%;
    }

    /* The circles on the timeline */
    .container_new::after {
        content: '';
        position: absolute;
        width: 25px;
        height: 25px;
        right: -13px;
        background-color: white;
        border: 2px solid #bd081b;
        top: 15px;
        border-radius: 50%;
        z-index: 1;

    }

    /* Place the container_new to the left */
    .left {
        left: 0;
    }

    /* Place the container_new to the right */
    .right {
        left: 50%;
    }

    /* Add arrows to the left container_new (pointing right) */
    .left::before {
        content: " ";
        height: 0;
        position: absolute;
        top: 22px;
        width: 0;
        z-index: 1;
        right: 30px;
        border: medium solid #bd081b;
        border-width: 10px 0 10px 10px;
        border-color: transparent transparent transparent #bd081b;
    }

    /* Add arrows to the right container_new (pointing left) */
    .right::before {
        content: " ";
        height: 0;
        position: absolute;
        top: 22px;
        width: 0;
        z-index: 1;
        left: 30px;
        border: medium solid #bd081b;
        border-width: 10px 10px 10px 0;
        border-color: transparent #bd081b transparent transparent;
    }

    /* Fix the circle for container_news on the right side */
    .right::after {
        left: -13px;
    }

    /* The actual content */
    .content_new {
        padding: 0px 30px;
        background-color: white;
        position: relative;
        border-radius: 6px;
    }

    /* Media queries - Responsive timeline on screens less than 600px wide */
    @media screen and () {
        /* Place the timelime to the left */
        .timeline::after {
            left: 31px;
        }

        /* Full-width container_news */
        .container_new {
            width: 100%;
            padding-left: 70px;
            padding-right: 25px;
        }

        /* Make sure that all arrows are pointing leftwards */
        .container_new::before {
            left: 60px;
            border: medium solid white;
            border-width: 10px 10px 10px 0;
            border-color: transparent white transparent transparent;
        }

        /* Make sure all circles are at the same spot */
        .left::after, .right::after {
            left: 15px;
        }

        /* Make all right container_news behave like the left ones */
        .right {
            left: 0%;
        }
    }
    body{ background-color:#fff !important;}
    .animate_dot{
        padding: 1px 40px;
        position: relative;
        background-color: inherit;

    }

    .animate_dot_left::after{
        content: '';
        position: absolute; 
        z-index: 999 !important;
        width: 17px;
        height: 17px;
        right: -10px;
        top: 18px; 
        border-radius: 50%;
        z-index: 1;
        margin:1px;
        display: block;
        border-radius: 50%;
        background:red;
        cursor: pointer;
        box-shadow: 0 0 0 rgba(204,169,44, 0.4);
        animation: pulse 2s infinite;
    }
    .animate_dot_right::after{
        content: '';
        position: absolute; 
        z-index: 999 !important;
        width: 17px;
        height: 17px;
        right: 371px;
        top: 18px; 
        border-radius: 50%;
        z-index: 1;
        margin:1px;
        display: block;
        border-radius: 50%;
        background:red;
        cursor: pointer;
        box-shadow: 0 0 0 rgba(204,169,44, 0.4);
        animation: pulse 2s infinite;
    }
    .box_content{
        padding: 0 30px;
        border-radius: 6px;
    }
    @-webkit-keyframes pulse {
        0% {
            -webkit-box-shadow: 0 0 0 0 rgba(255, 10, 10, 0.4);
        }
        70% {
            -webkit-box-shadow: 0 0 0 10px rgba(204,169,44, 0);
        }
        100% {
            -webkit-box-shadow: 0 0 0 0 rgba(204,169,44, 0);
        }
    }
    @keyframes pulse {
        0% {
            -moz-box-shadow: 0 0 0 0 rgba(255, 10, 10, 0.7);
            box-shadow: 0 0 0 0 rgba(255, 10, 10, 0.7);
        }
        70% {
            -moz-box-shadow: 0 0 0 10px rgba(204,169,44, 0);
            box-shadow: 0 0 0 10px rgba(204,169,44, 0);
        }
        100% {
            -moz-box-shadow: 0 0 0 0 rgba(204,169,44, 0);
            box-shadow: 0 0 0 0 rgba(204,169,44, 0);
        }
    }
</style>

<br><br><br>
<div class="timeline" style="background-color:#f9f9f9;padding:20px;">
    <h3 style="text-align:center;">Track Your Order<br> ( Order ID : #ORD<?php echo $order_id; ?> )</h3>
    <br><br><br>
    <?php
    $tot_count = count($hist_dat);
    $j = 1;
    $i = 2;
    foreach ($hist_dat as $row) {
        if ($i % 2 == 0) {
            $class = "left";
        } else {
            $class = "right";
        }

        //dot class
        if ($tot_count == $j) {
            if ($class == left) {
                $dotclass = "animate_dot_left";
            } else {
                $dotclass = "animate_dot_right";
            }
        } else {
            $dotclass = 'content_new';
        }
        ?>

        <div class="container_new <?php echo $class; ?>">
            <div class="<?php echo $dotclass; ?> box_content" style="background-color:#fff;color:#fff;border: 2px solid #bd081b;">
                <h3><?php echo $row->status; ?></h3>
                <p style="margin-top:-15px;"><?php echo $row->comment; ?></p>
                <p style="margin-top:-15px;"><?php echo date('d M Y H:i', strtotime($row->date_added)); ?></p>
        <?php
        if ($tot_count == $j) {
            ?>
                    <a id="popup" data-toggle="modal" data-target="#track_det" onclick="track_detail(<?php echo $order_id; ?>);" style="color:#000;cursor:pointer;">View Details</a>
    <?php }
    ?>
            </div>
        </div>
    <?php
    $i++;
    $j++;
}
?>

</div>
<br><br><br>
<div id="track_det" class="modal"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <!-- Modal content-->
        <div class="modal-content" style="margin:0 auto; width:70%;">
            <div class="modal-header">
                <h4 class="modal-title" >Shipped With ATZ Cart</h4>
                <h5 class="modal-title" >Track Order ID : #ORD<?php echo $order_id; ?> </h5>
               
            </div>
            <div class="modal-body">
                <div class="col-12 row">
                    <div class="col-12" id="trackOrder" style="height:400px;overflow:auto;"></div>
                </div>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>

            </div>  


        </div>

    </div>
</div>

<script>
    function track_detail(ord)
    {
        if (ord != '')
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>buyer/myorders/get_order_track_details',
                data: {'ord': ord},
                success: function (data) {
                    $('#trackOrder').html('');
                    $('#trackOrder').html(data);

                },
                error: function () {
                    alert('Somthing Wrong !');
                }
            });
        }
    }
</script>