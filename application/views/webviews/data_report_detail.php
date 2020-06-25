<html>
    <head>
        <title>Data Report Details</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/bower_components/bootstrap/css/bootstrap.min.css">
        <script src="<?php echo base_url(); ?>assets/bower_components/jquery/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <h3><?php echo $data_report['topic'];?></h3>
        <p><?php echo date('M d',strtotime($data_report['date_created']));?></p><br>
        <p><?php echo $data_report['short_description'];?></p>
        <h5>1.Overview</h5>
        <p><?php echo $data_report['overview'];?></p>
        <?php if(!empty($sub_category_product_inquiry)){?>
            <h5>2.atzcart.com list</h5>
            <h6>1)Inquiries Ranking</h6>
            <p>We Stored the products in lasw week list according the inquiry data following aret he top 10 items</p>
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Product Image</th>  
                    <th>Total Inquires</th>
                </tr>
                <?php foreach ($sub_category_product_inquiry as $product){ ?>
                    <tr>
                        <td><?php echo $product['products_name']; ?></td>
                        <td><a href="<?php echo $product['products_id']?>"><img src="<?php echo base_url('uploads/images/products/'.$product['products_image'])?>" style="height: 75px;width: 75px;"></a></td>
                        <td><?php echo $product['inquiry_count']; ?></td>
                    </tr>
                <?php } ?>
            </table>
            <?php $top_three = array_slice($sub_category_product_inquiry, 0,3);?>
            <?php $i=1; foreach ($top_three as $row){ ?>
            <p>#<?php echo $i;?></p>
            <a href="<?php echo $row['products_id']?>">
                <img src="<?php echo base_url('uploads/images/products/'.$row['products_image'])?>" alt="img" style="height: 250px;width:250px">
            </a>
            <?php $i++; } ?>
            
        <?php } ?>
        
        <p>Compared with the last analysis period,bows for girls hair,hair accessories,jihung packaging,barrete are included into our  list.This indicates a potential market worth attention</p>
        
        <?php if(!empty($sub_category_products)){
                   $numOfCols = 2;
                   $rowCount = 0;
                   $bootstrapColWidth = 12 / $numOfCols; ?>
                  
                    <div class="row">
                      <?php  foreach ($sub_category_products as $product){?>
                       
                        <div class="col-md-<?php echo $bootstrapColWidth; ?>">
                            <a href="<?php echo $product['products_id']?>">
                                <img src="<?php echo base_url('uploads/images/products/'.$product['products_image'])?>" alt="img" style="height: 75px;width:75px">
                                <h6><?php echo $product['products_name'];?></h6>
                                <p>MOQ:<?php echo $product['min_order_quantity'];?> Sets</p>
                                <p>INR <?php echo $product['products_price'];?></p>
                            </a>
                        </div>
                       
                       <?php
                       $rowCount++;
                       if($rowCount % $numOfCols == 0) echo '</div><div class="row">';
                        }
                        ?>

                    </div>
        <?php }?>
    </body>
</html>

