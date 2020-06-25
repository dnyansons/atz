<html>
    <head>
        <title>Payment Status</title>
        <style>
            header{
                background: #f1f1f1;
                color: green;
                text-align: center;
                padding: 10px;
            }
            .content{
                background: #f1f1f1;
                color: green;
                text-align: left;
                padding: 10px;
            }
            table{
                width: 100%;
                text-align: center;
                border: 1px solid #000;
            }
            table th{
                border: 1px solid #000;
            }
        </style>
    </head>
    <body>
        <header>
            <?php echo $status;?>
        </header>
        <div class="content">
            <table>
                <tr>
                    <th width="50%">Payment Mode</th>
                    <th width="50%"><?php echo $mode;?></th>
                </tr>
                <tr>
                    <th width="50%">Order id</th>
                    <th width="50%"><?php echo $order_id;?></th>
                </tr>
                <tr>
                    <th width="50%">Transaction id</th>
                    <th width="50%"><?php echo $trans_id;?></th>
                </tr>
                <tr>
                    <th>Amount</th>
                    <th><?php echo $amount;?></th>
                </tr>
            </table>
        </div>
    </body>
</html>