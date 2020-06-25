<?php 
//echo "<pre>";
//print_r($all_categories);
//exit;
?>
<?php $this->load->view("front/common/header"); ?>
<div style="background:#fff; margin-top:1px;" class="">
<div class="cg cg-page container-fluid" id="category" style="padding-top:20px;">
    <div class="en-us">
        <div class="ui-breadcrumb">
            <a href="<?php echo site_url();?>">Home</a>
            <span class="divider">&gt;</span>
            <h1 class="active">All Categories</h1>
        </div>
    </div>
    <h2 class="cg-title">Products by Category</h2><br><br>
    <table id="dddd" class="cg-nav-wrapper cg-nav-wrapper-row-2" data-role="cg-nav-wrapper" style="position: relative; left: 0px; top: 0px; bottom: 0px;">
    <tbody>
        <tbody>
            <tr>
            <?php $i = 0; foreach($root_categories as $rootCat): $i++;?>   
            <?php if($i == 7){ echo "</tr><tr>"; }?>
            <td class="anchor-wrap anchor1-wrap selected1 bg-gray" >
                <a class="anchor2" data-role="cont" href="#cat_<?php echo $rootCat->category_id;?>">
                    <img class="banner-subitem-image cat123" style="margin-left: 5px; background:#bd081b; border-radius:10px; padding:3px; float:left" src="<?php echo $rootCat->categories_image; ?>" width="35" height="35">
                    <span class="desc">
                        <?php echo $rootCat->categories_name; ?>
                    </span>
                </a>
            </td>            
            <?php endforeach;?>
            </tr>    
        </tbody>
    </table>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-10">
                <?php foreach($all_categories as $allCat):?>
             
                <h3 class="sub-title sub-titleh3" id="cat_<?php echo $allCat["id"];?>" 
				style="border-bottom:1px solid #ccc; padding-bottom:10px; padding-top:10px;">
                    <a href="<?php echo site_url().'catalog/'.preg_replace('~[^\\pL0-9_]+~u', '-', $allCat["title"]).'/'.$allCat["id"];?>">
                        <?php echo $allCat["title"];?>
                    </a>
                </h3>
				
                    <div class="row">
                        <?php foreach($allCat["elements"] as $elemens):?>
                            <div class="row">
                                <h5 class="sub-title">
								
                                    <a href="<?php echo site_url().'catalog/'.preg_replace('~[^\\pL0-9_]+~u', '-', $elemens->categories_name).'/'.$elemens->category_id;?>"  style="color:#1686cc">
                                        <?php echo $elemens->categories_name;?>
                                    </a>
                                </h5>
                                <ul id="myList">
                                    <?php foreach($elemens->sub as $sub):?>
                                    <li>
                                        <a href="<?php echo site_url().'catalog/'.preg_replace('~[^\\pL0-9_]+~u', '-',$sub->categories_name).'/'.$sub->category_id;?>">
                                          <?php echo $sub->categories_name;?>
                                        </a>
                                    </li>    
									
                                    <?php endforeach;?>
                                </ul>
                            </div>
                        <?php endforeach;?>
                    </div>
                <?php endforeach;?>
            </div>
 
        </div>   
</div><br><br>
</div>
<?php $this->load->view("front/common/footer"); ?>


                                    