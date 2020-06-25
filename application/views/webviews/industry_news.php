<html>
    <style>
        .button {
        font: bold 11px Arial;
        text-decoration: none;
        background-color: #f1a70a;
        color: #fff;
        padding: 2px 6px 2px 6px;
        border-top: 1px solid #CCCCCC;
        border-right: 1px solid #333333;
        border-bottom: 1px solid #333333;
        border-left: 1px solid #CCCCCC;
      }
    </style>
    <body>
        <center>
            
            <p><?php echo $details['short_description']; ?></p>
            <a class="button" href="<?php echo $details['publisher_url'];?>">Tab to read full article</a>
        </center>
    </body>
</html>

