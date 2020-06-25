<?xml version='1.0'?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo site_url("all_categories");?></loc>
        <priority>1.0</priority>
        <changefreq>daily</changefreq>
    </url>


    <!-- Sitemap -->
    <?php foreach($categories as $category) { ?>
    <url>
        <loc><?php echo site_url()."product-catalog/".str_replace("_","-",underscore(xml_convert($category->categories_name)))."/".$category->category_id;?></loc>
        <priority>0.5</priority>
        <changefreq>daily</changefreq>
    </url>
    <?php } ?>
</urlset>