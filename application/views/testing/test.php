<html>
    <head>
        <title>Testing aws</title>
    </head>
    <body>
        <form action="<?php echo site_url(); ?>test/test" method="POST" enctype="multipart/form-data">
            <img src="https://aynbucket.s3.ap-south-1.amazonaws.com/Desert.jpg" >
            <input type="file" name="image" />
            <input type="submit"/>
        </form>
    </body>
</html>