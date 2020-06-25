<html>
    <body>
        <h5>Company Profile</h5>
        <p><?php echo $details['company_profile']; ?></p>
        <?php if (!empty($details['company_profile_images_arr'])){
               foreach ($details['company_profile_images_arr'] as $img){ ?>
                 <img src="<?php echo $img;?>" style="height: 200px;width: 200px">
        <?php }} ?>
         <p><?php echo $details['company_competence']; ?></p> 
         <?php if (!empty($details['company_competence_images_arr'])){
               foreach ($details['company_competence_images_arr'] as $img){ ?>
                 <img src="<?php echo $img;?>" style="height: 200px;width: 200px">
         <?php }} ?>
         <p><?php echo $details['success_story']; ?></p>
         <?php if (!empty($details['company_competence_images_arr'])){
               foreach ($details['company_competence_images_arr'] as $img){ ?>
                 <img src="<?php echo $img;?>" style="height: 200px;width: 200px">
         <?php }} ?>         
    </body>
</html>

