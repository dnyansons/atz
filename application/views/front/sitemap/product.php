<?php echo'<?xml version="1.0" encoding="UTF-8" ?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    
    <!-- Sitemap -->
    <?php foreach($products as $product) { ?>
    <url>
        <loc><?php echo site_url()."product-details/".str_replace("_","-",underscore(xml_convert($product->name)))."/".$product->id;?></loc>
        <priority>0.5</priority>
        <changefreq>daily</changefreq>
    </url>
    <?php } ?>


</urlset>