<?php if(!empty($websiteUrl)){  ?>
        <p class="mt12 fr mb12 pl10 height20 "> 
            <a class="my_site fs16 pr30 " href="<?php echo $websiteUrl; ?>" target="_blank"><?php echo $this->lang->line('myWebsite');?></a>
        </p>
        
    <?php } ?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
    $websiteUrl        =   (!empty($websiteUrl))?$websiteUrl:'';
    $userSocialLinksCount = count($userSocialLinks);
   
    if(isset($userSocialLinks) && is_array($userSocialLinks) && $userSocialLinksCount > 0) { ?>
        <div class="main_w fr <?php echo ($userSocialLinksCount < 3)?"navi_less":""; ?>">
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
