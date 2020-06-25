<html>
    <head>
<!--        <META HTTP-EQUIV='REFRESH' CONTENT='1;URL=<?php echo base_url().$name;?>'>-->
    </head>
    <body>
        test
        <script>
            window.open('<?php echo base_url().$name;?>');
            setTimeout(function(){ window.location.href = "<?php echo site_url();?>seller/bulkimport" }, 5000);
        </script>
    </body>
</html>