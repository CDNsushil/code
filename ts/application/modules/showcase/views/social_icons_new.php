<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
    $websiteUrl        =   (!empty($websiteUrl))?$websiteUrl:'';
    if(isset($userSocialLinks) && is_array($userSocialLinks) && count($userSocialLinks)>0) { ?>
        <div class="main_w fl">
           <ul id="scroller">
            <?php foreach($userSocialLinks as $linkImage) { 
                            
                                if($linkImage->profileSocialMediaPath!='') {
                                        $link = addhttp($linkImage->socialLink);
                                        
                                         $linkClass ='';
                                         if($linkImage->profileSocialMediaName!='') {
                                              $linkClass = (str_replace(' ','_',$linkImage->profileSocialMediaName));					 
                                            }?>
              <li> <a href="<?php echo $link ?>" class="social_btn <?php echo $linkClass ?>"></a></li>
          <?php }       } ?>
           </ul>
        </div>
    <?php } ?> 
       
    <?php if(!empty($websiteUrl)){  ?>
        <a class="my_site fs16 pr30 mt12" href="<?php echo $websiteUrl; ?>" target="_blank"><?php echo $this->lang->line('myWebsite');?></a>
    <?php } ?>
