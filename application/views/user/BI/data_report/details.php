<html>
    <head>
        <title>Data Report Details</title>
    </head>
    <body>
        <h3>Analysis Report of atzcart.com <?php echo $details['topic'];?></h3>
        <p><?php echo date('Y-m-d', strtotime($details['date_created']))?></p><br>
        <p><?php echo $details['short_description'];?> </p>
        <h2>1.Overview</h2>
        <p><?php echo $details['overview'];?></p>
        <h2>2.AZ.com list</h2>
        <h3>1)Inquiries Ranking</h3>
        <p>We Stored the products in lasw week list according the inquiry data following aret he top 10 items</p>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Product Image</th>  
                <th>Total Inquires</th>
            </tr>
            <tr>
                <td>BCD154 cotton linnen pure color kids overails</td>
                <td><a href="product_id=3&token=xy12356"><img src="https://via.placeholder.com/150"></a></td>
                <td>1</td>
            </tr>
        </table>
    </body>
</html>

